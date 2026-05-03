<?php

namespace App\Http\Controllers;

use App\Models\AmenityRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\AmenityItem;

class AmenityRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = AmenityRequest::query()
            ->with([
                'booking.guest',
                'booking.rooms',
                'amenityItem',
                'requester',
                'approver',
                'fulfiller',
                'folioCharge',
            ])
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('item_name', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                            $bookingQuery->where('booking_code', 'like', "%{$search}%");
                        })
                        ->orWhereHas('booking.guest', function ($guestQuery) use ($search) {
                            $guestQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->status, fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $activeBookings = Booking::query()
            ->with(['guest', 'rooms'])
            ->where('status', 'checked_in')
            ->latest()
            ->get();

        $amenityItems = AmenityItem::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('pages.amenity-requests.index', compact(
            'requests',
            'activeBookings',
            'amenityItems'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'amenity_item_id' => ['required', 'exists:amenity_items,id'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if (strtolower($booking->status) !== 'checked_in') {
            return back()->withErrors([
                'booking_id' => 'Only checked-in bookings can request amenities or consumables.',
            ])->withInput();
        }

        $item = AmenityItem::findOrFail($validated['amenity_item_id']);

        if (! $item->is_active) {
            return back()->withErrors([
                'amenity_item_id' => 'Selected item is inactive.',
            ])->withInput();
        }

        if ($item->stock_quantity < $validated['quantity']) {
            return back()->withErrors([
                'amenity_item_id' => 'Not enough stock for ' . $item->name . '. Available: ' . $item->stock_quantity,
            ])->withInput();
        }

        AmenityRequest::create([
            'booking_id' => $booking->id,
            'amenity_item_id' => $item->id,
            'item_name' => $item->name,
            'category' => $item->category,
            'quantity' => $validated['quantity'],
            'unit_price' => $item->unit_price,
            'is_chargeable' => $item->is_chargeable,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'requested_by' => auth()->id(),
        ]);

        return back()->with('success', 'Amenity/consumable request created successfully.');
    }

    public function approve(AmenityRequest $amenityRequest)
    {
        if ($amenityRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        $amenityRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Request approved successfully.');
    }

    public function reject(Request $request, AmenityRequest $amenityRequest)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        if (! in_array($amenityRequest->status, ['pending', 'approved'])) {
            return back()->with('error', 'This request cannot be rejected.');
        }

        $amenityRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Request rejected successfully.');
    }

    public function fulfill(AmenityRequest $amenityRequest)
    {
        if (! in_array($amenityRequest->status, ['pending', 'approved'])) {
            return back()->with('error', 'Only pending or approved requests can be fulfilled.');
        }

        DB::transaction(function () use ($amenityRequest) {
            $amenityRequest = AmenityRequest::lockForUpdate()->findOrFail($amenityRequest->id);

            if (! in_array($amenityRequest->status, ['pending', 'approved'])) {
                abort(422, 'Only pending or approved requests can be fulfilled.');
            }

            $booking = Booking::lockForUpdate()->findOrFail($amenityRequest->booking_id);

            if (strtolower($booking->status) !== 'checked_in') {
                abort(422, 'Booking must be checked-in before fulfilling this request.');
            }

            $item = null;

            if ($amenityRequest->amenity_item_id) {
                $item = AmenityItem::lockForUpdate()->find($amenityRequest->amenity_item_id);

                if (! $item) {
                    abort(422, 'Amenity item no longer exists.');
                }

                if ($item->stock_quantity < $amenityRequest->quantity) {
                    abort(422, 'Not enough stock for ' . $item->name . '.');
                }

                $item->decrement('stock_quantity', (int) $amenityRequest->quantity);
            }

            $folioChargeId = $amenityRequest->folio_charge_id;

            if ($amenityRequest->is_chargeable && ! $folioChargeId) {
                $charge = $booking->folioCharges()->create([
                    'category' => $amenityRequest->category,
                    'description' => 'Amenity Request: ' . $amenityRequest->item_name,
                    'quantity' => $amenityRequest->quantity,
                    'unit_price' => $amenityRequest->unit_price,
                    'amount' => $amenityRequest->total_amount,
                    'created_by' => auth()->id(),
                ]);

                $folioChargeId = $charge->id;
            }

            $amenityRequest->update([
                'status' => 'fulfilled',
                'fulfilled_by' => auth()->id(),
                'fulfilled_at' => now(),
                'folio_charge_id' => $folioChargeId,
            ]);

            $this->syncBookingBalance($booking);
        });

        return back()->with('success', 'Request fulfilled and added to folio successfully.');
    }

    private function syncBookingBalance(Booking $booking): void
    {
        $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
        $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

        $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
        $balance = round(max($grandTotal - $paidAmount, 0), 2);

        if ($balance < 0.01) {
            $balance = 0.00;
        }

        $booking->update([
            'paid_amount' => $paidAmount,
            'balance' => $balance,
            'payment_status' => match (true) {
                $paidAmount <= 0 => 'unpaid',
                $paidAmount >= $grandTotal => 'paid',
                default => 'partial',
            },
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RfidCard;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RfidCheckInController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::query()
            ->with(['guest', 'rooms', 'rfidCard'])
            ->whereIn('status', ['confirmed', 'reserved'])
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('booking_code', 'like', "%{$search}%")
                        ->orWhereHas('guest', function ($guestQuery) use ($search) {
                            $guestQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.rfid-check-in.index', compact('bookings'));
    }

    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'rfid_uid' => ['required', 'string', 'max:255'],
        ]);

        $booking->load(['rooms', 'payments']);

        if (! in_array(strtolower($booking->status), ['confirmed', 'reserved'])) {
            return back()->withErrors([
                'rfid_uid' => 'Only confirmed or reserved bookings can be checked in.',
            ]);
        }

        if ($booking->rfid_card_id) {
            return back()->withErrors([
                'rfid_uid' => 'This booking already has an assigned RFID card.',
            ]);
        }

        /**
         * Folio-aware balance check:
         * Room total + active folio charges - payments
         */
        $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
        $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

        $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
        $balance = round($grandTotal - $paidAmount, 2);

        if ($balance < 0.01) {
            $balance = 0.00;
        }

        if ($balance > 0) {
            return back()->withErrors([
                'rfid_uid' => 'Guest must be fully paid before RFID check-in. Remaining balance: ₱' . number_format($balance, 2),
            ]);
        }

        if ($booking->rooms->isEmpty()) {
            return back()->withErrors([
                'rfid_uid' => 'This booking has no assigned room.',
            ]);
        }

        foreach ($booking->rooms as $room) {
            if (strtolower($room->status) !== 'available') {
                return back()->withErrors([
                    'rfid_uid' => 'One or more assigned rooms are not available for check-in.',
                ]);
            }
        }

        $uid = trim($validated['rfid_uid']);

        $rfidCard = RfidCard::where('uid', $uid)->first();

        if (! $rfidCard) {
            return back()->withErrors([
                'rfid_uid' => 'RFID card is not registered.',
            ]);
        }

        if (strtolower($rfidCard->status) !== 'available') {
            return back()->withErrors([
                'rfid_uid' => 'This RFID card is not available.',
            ]);
        }

        DB::transaction(function () use ($booking, $rfidCard, $balance, $paidAmount) {
            $booking = Booking::lockForUpdate()->findOrFail($booking->id);
            $booking->load(['rooms', 'payments']);

            if (! in_array(strtolower($booking->status), ['confirmed', 'reserved'])) {
                abort(422, 'This booking is no longer eligible for RFID check-in.');
            }

            if ($booking->rfid_card_id) {
                abort(422, 'This booking already has an assigned RFID card.');
            }

            $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
            $currentPaidAmount = round((float) $booking->payments()->sum('amount'), 2);

            $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
            $currentBalance = round($grandTotal - $currentPaidAmount, 2);

            if ($currentBalance < 0.01) {
                $currentBalance = 0.00;
            }

            if ($currentBalance > 0) {
                abort(422, 'Guest still has an unpaid balance of ₱' . number_format($currentBalance, 2) . '.');
            }

            $lockedCard = RfidCard::lockForUpdate()->findOrFail($rfidCard->id);

            if (strtolower($lockedCard->status) !== 'available') {
                abort(422, 'This RFID card is no longer available.');
            }

            foreach ($booking->rooms as $room) {
                $lockedRoom = Room::lockForUpdate()->findOrFail($room->id);

                if (strtolower($lockedRoom->status) !== 'available') {
                    abort(422, 'One or more assigned rooms are not available for check-in.');
                }

                $lockedRoom->update([
                    'status' => 'Occupied',
                ]);
            }

            $booking->update([
                'rfid_card_id' => $lockedCard->id,
                'paid_amount' => $currentPaidAmount,
                'balance' => $currentBalance,
                'payment_status' => 'paid',
                'status' => 'checked_in',
                'checked_in_at' => now(),
            ]);

            $lockedCard->update([
                'status' => 'assigned',
            ]);
        });

        return redirect()
            ->route('rfid.check-in.index')
            ->with('success', 'Guest checked in successfully using RFID.');
    }
}
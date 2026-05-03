<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\FolioCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolioChargeController extends Controller
{
    public function index(Booking $booking)
    {
        $booking->load([
            'guest',
            'rooms.roomType',
            'folioCharges.creator',
            'payments',
        ]);

        $activeChargesTotal = $booking->activeFolioCharges()->sum('amount');
        $voidedChargesTotal = $booking->folioCharges()->where('is_void', true)->sum('amount');
        $paidTotal = $booking->payments()->sum('amount');

        $grandTotal = $booking->total_price + $activeChargesTotal;
        $balance = max($grandTotal - $paidTotal, 0);

        return view('pages.folios.index', compact(
            'booking',
            'activeChargesTotal',
            'voidedChargesTotal',
            'paidTotal',
            'grandTotal',
            'balance'
        ));
    }

    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($booking, $validated) {
            $booking->folioCharges()->create([
                'category' => $validated['category'],
                'description' => $validated['description'],
                'quantity' => $validated['quantity'],
                'unit_price' => $validated['unit_price'],
                'amount' => round($validated['quantity'] * $validated['unit_price'], 2),
                'created_by' => auth()->id(),
            ]);

            $this->syncBookingBalance($booking);
        });

        return back()->with('success', 'Charge added to folio successfully.');
    }

    public function void(Request $request, FolioCharge $charge)
    {
        $validated = $request->validate([
            'void_reason' => ['required', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($charge, $validated) {
            $charge->update([
                'is_void' => true,
                'void_reason' => $validated['void_reason'],
                'voided_at' => now(),
                'voided_by' => auth()->id(),
            ]);

            $this->syncBookingBalance($charge->booking);
        });

        return back()->with('success', 'Charge voided successfully.');
    }

    private function syncBookingBalance(Booking $booking): void
    {
        $chargesTotal = $booking->activeFolioCharges()->sum('amount');
        $paidTotal = $booking->payments()->sum('amount');

        $grandTotal = round($booking->total_price + $chargesTotal, 2);
        $balance = round(max($grandTotal - $paidTotal, 0), 2);

        $booking->update([
            'balance' => $balance,
            'payment_status' => match (true) {
                $paidTotal <= 0 => 'unpaid',
                $paidTotal >= $grandTotal => 'paid',
                default => 'partial',
            },
        ]);
    }
}
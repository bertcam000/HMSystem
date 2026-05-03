<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RfidCard;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RfidCheckOutController extends Controller
{
    public function index()
    {
        return view('pages.rfid-check-out.index', [
            'booking' => null,
            'rfidUid' => null,
        ]);
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'rfid_uid' => ['required', 'string', 'max:255'],
        ]);

        $rfidUid = trim($validated['rfid_uid']);

        $rfidCard = RfidCard::where('uid', $rfidUid)->first();

        if (! $rfidCard) {
            return back()->withErrors([
                'rfid_uid' => 'RFID card is not registered.',
            ])->withInput();
        }

        $booking = Booking::query()
            ->with(['guest', 'rooms', 'rfidCard', 'payments'])
            ->where('rfid_card_id', $rfidCard->id)
            ->where('status', 'checked_in')
            ->latest()
            ->first();

        if (! $booking) {
            return redirect()
                ->route('rfid.check-out.index')
                ->withErrors([
                    'rfid_uid' => 'No active checked-in booking found for this RFID card.',
                ]);
        }

        return view('pages.rfid-check-out.index', [
            'booking' => $booking,
            'rfidUid' => $rfidUid,
        ]);
    }

    public function checkout(Request $request, Booking $booking)
    {
        if (strtolower($booking->status) !== 'checked_in') {
            return redirect()
                ->route('rfid.check-out.index')
                ->withErrors([
                    'checkout' => 'Only checked-in bookings can be checked out.',
                ]);
        }

        $booking->load(['rooms', 'rfidCard', 'payments']);

        // Folio-aware balance:
        // Room total + active folio charges - payments
        $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
        $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

        $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
        $balance = round($grandTotal - $paidAmount, 2);

        if ($balance < 0.01) {
            $balance = 0.00;
        }

        if ($balance > 0) {
            return back()->withErrors([
                'checkout' => 'Cannot check out. Guest still has remaining balance of ₱' . number_format($balance, 2),
            ]);
        }

        DB::transaction(function () use ($booking) {
            $booking = Booking::lockForUpdate()->findOrFail($booking->id);
            $booking->load(['rooms', 'rfidCard', 'payments']);

            if (strtolower($booking->status) !== 'checked_in') {
                abort(422, 'This booking is no longer eligible for RFID check-out.');
            }

            // Recheck inside transaction para safe
            $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
            $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

            $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
            $balance = round($grandTotal - $paidAmount, 2);

            if ($balance < 0.01) {
                $balance = 0.00;
            }

            if ($balance > 0) {
                abort(422, 'Guest still has remaining balance of ₱' . number_format($balance, 2) . '.');
            }

            $rfidCard = $booking->rfidCard;

            if ($rfidCard) {
                $lockedCard = RfidCard::lockForUpdate()->find($rfidCard->id);

                if ($lockedCard) {
                    $lockedCard->update([
                        'status' => 'available',
                    ]);
                }
            }

            foreach ($booking->rooms as $room) {
                $lockedRoom = Room::lockForUpdate()->find($room->id);

                if ($lockedRoom) {
                    $lockedRoom->update([
                        'status' => 'Dirty',
                    ]);
                }
            }

            $booking->update([
                'paid_amount' => $paidAmount,
                'balance' => $balance,
                'payment_status' => 'paid',
                'status' => 'checked_out',
                'checked_out_at' => now(),
                'rfid_card_id' => null,
            ]);
        });

        return redirect()
            ->route('rfid.check-out.index')
            ->with('success', 'Guest checked out successfully. RFID card is now available again.');
    }
}
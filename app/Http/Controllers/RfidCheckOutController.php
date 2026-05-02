<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RfidCard;
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
            ->with(['guest', 'rooms', 'rfidCard'])
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
        if ($booking->status !== 'checked_in') {
            return redirect()
                ->route('rfid.check-out.index')
                ->withErrors([
                    'checkout' => 'Only checked-in bookings can be checked out.',
                ]);
        }

        $booking->load(['rooms', 'rfidCard']);

        $balance = round((float) ($booking->total_price ?? 0) - (float) ($booking->paid_amount ?? 0), 2);

        if ($balance > 0) {
            return back()->withErrors([
                'checkout' => 'Cannot check out. Guest still has remaining balance of ₱' . number_format($balance, 2),
            ]);
        }

        DB::transaction(function () use ($booking) {
            $rfidCard = $booking->rfidCard;

            $booking->update([
                'status' => 'checked_out',
                'checked_out_at' => now(),
                'rfid_card_id' => null,
            ]);

            if ($rfidCard) {
                $rfidCard->update([
                    'status' => 'available',
                ]);
            }

            foreach ($booking->rooms as $room) {
                $room->update([
                    'status' => 'Dirty',
                ]);
            }
        });

        return redirect()
            ->route('rfid.check-out.index')
            ->with('success', 'Guest checked out successfully. RFID card is now available again.');
    }
}
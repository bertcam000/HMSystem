<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{

    public function show(Booking $booking)
    {
        $booking->load([
            'guest',
            'rooms.roomType',
            'payments',
        ]);

        if (strtolower($booking->status) !== 'checked_in') {
            return redirect()->back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        return view('pages.check-out.index', [
            'booking' => $booking,
            'guest' => $booking->guest,
        ]);
    }

    public function store(Request $request, Booking $booking)
    {
        $booking->load([
            'guest',
            'rooms',
            'payments',
        ]);

        if (strtolower($booking->status) !== 'checked_in') {
            return redirect()->back()->with('error', 'This booking is not eligible for check-out.');
        }

        // Room total + active folio charges - payments
        $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
        $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

        $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
        $balance = round($grandTotal - $paidAmount, 2);

        if ($balance < 0.01) {
            $balance = 0.00;
        }

        if ($balance > 0) {
            return redirect()->back()->with(
                'error',
                'Guest still has an unpaid balance of ₱' . number_format($balance, 2) . '. Please settle payment before check-out.'
            );
        }

        DB::transaction(function () use ($booking) {
            $booking = Booking::lockForUpdate()->findOrFail($booking->id);
            $booking->load(['rooms', 'payments']);

            if (strtolower($booking->status) !== 'checked_in') {
                abort(422, 'This booking is no longer eligible for check-out.');
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
                abort(422, 'Guest still has an unpaid balance of ₱' . number_format($balance, 2) . '.');
            }

            $booking->update([
                'balance' => $balance,
                'payment_status' => 'paid',
                'status' => 'checked_out',
                'checked_out_at' => now(),
            ]);

            foreach ($booking->rooms as $room) {
                $lockedRoom = Room::lockForUpdate()->find($room->id);

                if ($lockedRoom) {
                    $lockedRoom->update([
                        'status' => 'Dirty',
                    ]);
                }
            }
        });

        return redirect('/booking/result/' . $booking->id)
            ->with('success', 'Guest checked out successfully.');
    }
    
}

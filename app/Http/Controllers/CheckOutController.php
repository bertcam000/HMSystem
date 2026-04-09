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

        if ((float) $booking->balance > 0) {
            return redirect()->back()->with('error', 'Guest still has an unpaid balance. Please settle payment before check-out.');
        }

        DB::transaction(function () use ($booking) {
            $booking = Booking::lockForUpdate()->findOrFail($booking->id);
            $booking->load('rooms');

            if (strtolower($booking->status) !== 'checked_in') {
                abort(422, 'This booking is no longer eligible for check-out.');
            }

            $booking->update([
                'status' => 'checked_out',
                'checked_out_at' => now(),
            ]);

            foreach ($booking->rooms as $room) {
                $lockedRoom = Room::lockForUpdate()->find($room->id);

                if ($lockedRoom) {
                    $lockedRoom->update([
                        'status' => 'Available',
                    ]);
                }
            }
        });

        return redirect('/booking/result/' . $booking->id)
            ->with('success', 'Guest checked out successfully.');
    }
    
}

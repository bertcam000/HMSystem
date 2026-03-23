<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::query()
            ->with(['rooms', 'guest', 'payments']);

       if ($request->filled('booking_code')) {
            $search = strtolower($request->booking_code);

            $query->whereRaw(
                'LOWER(booking_code) LIKE ?',
                ["%{$search}%"]
            );
        }

        if ($request->filled('status')) {
            $query->where('status', 'like', '%'.$request->status.'%');
        }

        if ($request->filled('room_type_id')) {
            $query->where('room_type_id', $request->room_type_id);
        }

        $bookings = $query->paginate(10)->withQueryString();

        // For dropdown + counts
        return view(
            'pages.booking.index',
            compact('bookings')
        );
    }

    public function checkIn(Booking $booking)
    {
        $booking->load('rooms');

        if ($booking->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Only confirmed bookings can be checked in.');
        }

        if ($booking->rooms->isEmpty()) {
            return redirect()->back()->with('error', 'This booking has no assigned rooms.');
        }

        // Optional strict rule:
        // if ($booking->payment_status === 'unpaid') {
        //     return redirect()->back()->with('error', 'Guest must have at least one payment before check-in.');
        // }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'checked_in',
                'checked_in_at' => now(),
            ]);

            foreach ($booking->rooms as $room) {
                $room->update([
                    'status' => 'Occupied',
                ]);
            }
        });

        return redirect()->back()->with('success', 'Guest checked in successfully.');
    }


    public function checkOut(Booking $booking)
    {
        $booking->load('rooms');

        if ($booking->status !== 'checked_in') {
            return redirect()->back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        if ($booking->rooms->isEmpty()) {
            return redirect()->back()->with('error', 'This booking has no assigned rooms.');
        }

        if ((float) $booking->balance > 0) {
            return redirect()->back()->with('error', 'Guest still has remaining balance.');
        }

        try {
            DB::transaction(function () use ($booking) {
                $booking->update([
                    'status' => 'checked_out',
                    'checked_out_at' => now(),
                ]);

                foreach ($booking->rooms as $room) {
                    $room->update([
                        'status' => 'Available',
                    ]);
                }
            });

            return redirect()->back()->with('success', 'Guest checked out successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Unable to check out guest.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['guest', 'rooms.roomType', 'payments']);

        $nights = Carbon::parse($booking->check_in_date)
            ->diffInDays(Carbon::parse($booking->check_out_date));
        
        return view('pages.booking.show', compact('booking', 'nights'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

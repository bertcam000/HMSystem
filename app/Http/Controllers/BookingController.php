<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;

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

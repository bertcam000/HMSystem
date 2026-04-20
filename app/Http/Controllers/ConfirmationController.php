<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    public function index(Request $request)
    {
        $booking = null;

        if ($request->filled('booking')) {
            $booking = Booking::with([
                'guest',
                'rooms.roomType.images',
            ])->find($request->booking);
        }

        if (!$booking) {
            return redirect()->route('availability.index');
        }

        return view('public.confirmation', compact('booking'));
    }
}
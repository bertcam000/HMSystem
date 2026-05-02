<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RfidCard;
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

        if (! in_array($booking->status, ['confirmed', 'reserved'])) {
            return back()->withErrors([
                'rfid_uid' => 'Only confirmed or reserved bookings can be checked in.',
            ]);
        }

        if ($booking->rfid_card_id) {
            return back()->withErrors([
                'rfid_uid' => 'This booking already has an assigned RFID card.',
            ]);
        }

        $uid = trim($validated['rfid_uid']);

        $rfidCard = RfidCard::where('uid', $uid)->first();

        if (! $rfidCard) {
            return back()->withErrors([
                'rfid_uid' => 'RFID card is not registered.',
            ]);
        }

        if ($rfidCard->status !== 'available') {
            return back()->withErrors([
                'rfid_uid' => 'This RFID card is not available.',
            ]);
        }

        DB::transaction(function () use ($booking, $rfidCard) {
            $booking->update([
                'rfid_card_id' => $rfidCard->id,
                'status' => 'checked_in',
                'checked_in_at' => now(),
            ]);

            $rfidCard->update([
                'status' => 'assigned',
            ]);

            foreach ($booking->rooms as $room) {
                $room->update([
                    'status' => 'Occupied',
                ]);
            }
        });

        return redirect()
            ->route('rfid.check-in.index')
            ->with('success', 'Guest checked in successfully using RFID.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $roomType = null;
        $availableRooms = collect();
        $availableRoomTypes = collect();

        $checkin = $request->checkin;
        $checkout = $request->checkout;
        $adults = (int) $request->adults;
        $children = (int) $request->children;
        $roomsRequested = max((int) $request->rooms, 1);
        $roomTypeId = $request->room_type;

        if ($roomTypeId) {
            $roomType = RoomType::with('images')->find($roomTypeId);
        }

        if ($checkin && $checkout) {
            $roomQuery = Room::with(['roomType.images'])
                ->where('status', 'Available');

            if ($roomTypeId) {
                $roomQuery->where('room_type_id', $roomTypeId);
            }

            $rooms = $roomQuery->get()->filter(function ($room) use ($checkin, $checkout) {
                return !Booking::whereIn('status', ['pending', 'confirmed', 'checked_in'])
                    ->whereHas('rooms', function ($query) use ($room) {
                        $query->where('rooms.id', $room->id);
                    })
                    ->where(function ($query) use ($checkin, $checkout) {
                        $query->where('check_in_date', '<', $checkout)
                              ->where('check_out_date', '>', $checkin);
                    })
                    ->exists();
            })->values();

            $availableRooms = $rooms;

            $availableRoomTypes = $rooms
                ->groupBy('room_type_id')
                ->map(function ($group) {
                    $firstRoom = $group->first();
                    return [
                        'room_type' => $firstRoom->roomType,
                        'available_count' => $group->count(),
                        'rooms' => $group->values(),
                    ];
                })
                ->values();
        }

        return view('public.availability', compact(
            'roomType',
            'availableRooms',
            'availableRoomTypes'
        ));
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'room_type' => ['required', 'exists:room_types,id'],
            'checkin'   => ['required', 'date'],
            'checkout'  => ['required', 'date', 'after:checkin'],
            'rooms'     => ['required', 'integer', 'min:1'],
        ]);

        $requiredRooms = (int) $validated['rooms'];

        $availableRooms = Room::where('room_type_id', $validated['room_type'])
            ->where('status', 'Available')
            ->get()
            ->filter(function ($room) use ($validated) {
                return !Booking::whereIn('status', ['pending', 'confirmed', 'checked_in'])
                    ->whereHas('rooms', function ($query) use ($room) {
                        $query->where('rooms.id', $room->id);
                    })
                    ->where(function ($query) use ($validated) {
                        $query->where('check_in_date', '<', $validated['checkout'])
                              ->where('check_out_date', '>', $validated['checkin']);
                    })
                    ->exists();
            })
            ->values();

        $availableCount = $availableRooms->count();

        return response()->json([
            'available' => $availableCount >= $requiredRooms,
            'available_rooms' => $availableCount,
            'message' => $availableCount >= $requiredRooms
                ? "{$availableCount} room(s) available for your selected stay."
                : "Not enough rooms available for the selected stay.",
        ]);
    }
}
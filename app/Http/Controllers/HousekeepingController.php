<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HousekeepingController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('roomType')->orderBy('room_number');

        if ($request->filled('status')) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                    ->orWhereHas('roomType', function ($roomTypeQuery) use ($search) {
                        $roomTypeQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $rooms = $query->get();

        $availableCount = Room::where('status', 'Available')->count();
        $occupiedCount = Room::where('status', 'Occupied')->count();
        $dirtyCount = Room::where('status', 'Dirty')->count();
        $cleaningCount = Room::where('status', 'Cleaning')->count();
        $maintenanceCount = Room::where('status', 'Maintenance')->count();

        return view('pages.housekeeping.index', compact(
            'rooms',
            'availableCount',
            'occupiedCount',
            'dirtyCount',
            'cleaningCount',
            'maintenanceCount'
        ));
    }

    public function startCleaning(Room $room)
    {
        if (strtolower($room->status) !== 'dirty') {
            return redirect()->back()->with('error', 'Only dirty rooms can be moved to cleaning.');
        }

        $room->update([
            'status' => 'Cleaning',
        ]);

        return redirect()->back()->with('success', 'Room marked as cleaning.');
    }

    public function markClean(Room $room)
    {
        if (!in_array(strtolower($room->status), ['dirty', 'cleaning'])) {
            return redirect()->back()->with('error', 'Only dirty or cleaning rooms can be marked available.');
        }

        $room->update([
            'status' => 'Available',
        ]);

        return redirect()->back()->with('success', 'Room marked as available.');
    }

    public function markMaintenance(Room $room)
    {
        if (strtolower($room->status) === 'occupied') {
            return redirect()->back()->with('error', 'Occupied room cannot be marked as maintenance.');
        }

        $room->update([
            'status' => 'Maintenance',
        ]);

        return redirect()->back()->with('success', 'Room marked as maintenance.');
    }

    public function markDirty(Room $room)
    {
        if (strtolower($room->status) === 'occupied') {
            return redirect()->back()->with('error', 'Occupied room cannot be marked as dirty manually.');
        }

        $room->update([
            'status' => 'Dirty',
        ]);

        return redirect()->back()->with('success', 'Room marked as dirty.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Room::query()
            ->with(['roomType', 'bookings']);

       if ($request->filled('room_number')) {
            $search = strtolower($request->room_number);

            $query->whereRaw(
                'LOWER(room_number) LIKE ?',
                ["%{$search}%"]
            );
        }

        if ($request->filled('status')) {
            $query->where('status', 'like', '%'.$request->status.'%');
        }

        if ($request->filled('room_type_id')) {
            $query->where('room_type_id', $request->room_type_id);
        }

        $rooms = $query->paginate(10)->withQueryString();

        // For dropdown + counts
        $roomTypes = RoomType::withCount('rooms')->get();
        $roomCount = Room::count();

        return view(
            'pages.room.room-list',
            compact('rooms', 'roomTypes', 'roomCount')
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
    public function show(string $id)
    {
        //
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

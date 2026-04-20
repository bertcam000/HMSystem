<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class PublicReservationController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with(['images', 'rooms'])
            ->whereHas('rooms', function ($query) {
                $query->where('status', 'Available');
            })
            ->latest()
            ->get();

        return view('public.offers', compact('roomTypes'));
    }
}
  
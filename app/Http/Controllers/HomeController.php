<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRoomTypes = RoomType::with(['images', 'rooms'])
            ->whereHas('rooms', function ($query) {
                $query->where('status', 'Available');
            })
            ->latest()
            ->take(3)
            ->get();

        $roomTypes = RoomType::orderBy('name')->get();

        return view('public.index', compact('featuredRoomTypes', 'roomTypes'));
    }
}
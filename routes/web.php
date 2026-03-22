<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Dashboard
Route::view('dashboard', 'pages.dashboard.index');
// Route::view('rooms', 'pages.room.index');
Route::view('housekeeping', 'pages.housekeeping.index');
Route::view('invoices', 'pages.invoices.index');
// Guests
Route::get('/guests', [GuestController::class, 'index']);
// RoomType
Route::get('/room-type', [RoomTypeController::class, 'index']);
Route::delete('/rooms/delete/{roomType}', [RoomTypeController::class, 'destroy']);

// Rooms
Route::get('/rooms', [RoomController::class, 'index']);

// Events
Route::view('events', 'pages.event.index');

// booking
Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/booking/result/{booking}', [BookingController::class, 'show']);
Route::view('/show-booking', 'pages.booking.show');
Route::view('/book', 'pages.booking.booking');

// 
Route::get('/guest/search', function (\Illuminate\Http\Request $request) {
    return \App\Models\Guest::query()
        ->when($request->search, function ($q) use ($request) {
            $search = $request->search;

            $q->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("first_name || ' ' || last_name LIKE ?", ["%{$search}%"]);
            });
        })
        ->limit(10)
        ->get()
        ->map(fn ($guest) => [
            'id' => $guest->id,
            'label' => $guest->first_name . ' ' . $guest->last_name,
        ]);
})->name('guest.search');
// 

require __DIR__.'/auth.php';

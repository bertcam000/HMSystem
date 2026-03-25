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

// Route::middleware('auth')->group(function() {
    // Dashboard
    Route::view('dashboard', 'pages.dashboard.index')->name('dashboard');
    // Route::view('rooms', 'pages.room.index');
    Route::view('housekeeping', 'pages.housekeeping.index');
    Route::view('invoices', 'pages.invoices.index');
    // Guests
    Route::get('/guests', [GuestController::class, 'index']);
    Route::get('/guest/edit/{guest}', [GuestController::class, 'edit']);
    Route::put('/guest/update/{guest}', [GuestController::class, 'update'])->name('guest.update');
    Route::delete('/guest/delete/{guest}', [GuestController::class, 'destroy']);
    // RoomType
    Route::get('/room-type', [RoomTypeController::class, 'index']);
    Route::delete('/rooms/delete/{roomType}', [RoomTypeController::class, 'destroy']);

    // Rooms
    Route::get('/rooms', [RoomController::class, 'index']);

    // Events
    Route::view('events', 'pages.event.index');

    // booking
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::view('/show-booking', 'pages.booking.show');
    Route::view('/book', 'pages.booking.booking');
    Route::get('/booking/result/{booking}', [BookingController::class, 'show']);
    Route::get('/booking/check-in/{booking}', [BookingController::class, 'checkIn']);
    Route::get('/booking/check-out/{booking}', [BookingController::class, 'checkOut']);


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
// });

require __DIR__.'/auth.php';

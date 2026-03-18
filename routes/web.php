<?php

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
Route::view('bookings', 'pages.booking.index');
Route::view('rooms', 'pages.rooms.index');
Route::view('guests', 'pages.guest.index');
Route::view('housekeeping', 'pages.housekeeping.index');
Route::view('invoices', 'pages.invoices.index');

// Events
Route::view('events', 'pages.event.index');

// 
Route::get('/users/search', function (\Illuminate\Http\Request $request) {
    return \App\Models\User::query()
        ->when($request->search, fn ($q) =>
            $q->where('name', 'like', "%{$request->search}%")
        )
        ->limit(10)
        ->get()
        ->map(fn ($user) => [
            'id' => $user->id,
            'name' => $user->name,
        ]);
})->name('users.search');
// 

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NightAuditController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\HousekeepingTaskController;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Route::middleware(['auth', 'role:admin,staff'])->group(function () {
//     // Dashboard
//     Route::view('dashboard', 'pages.dashboard.index')->name('dashboard');
//     // Route::view('rooms', 'pages.room.index');
//     Route::view('housekeeping', 'pages.housekeeping.index');
//     Route::view('invoices', 'pages.invoices.index');
//     // RoomType
//     Route::get('/room-type', [RoomTypeController::class, 'index']);
//     Route::delete('/rooms/delete/{roomType}', [RoomTypeController::class, 'destroy']);

//     // Guests
//     Route::get('/guests', [GuestController::class, 'index']);
//     Route::get('/guest/edit/{guest}', [GuestController::class, 'edit']);
//     Route::put('/guest/update/{guest}', [GuestController::class, 'update'])->name('guest.update');
//     Route::delete('/guest/delete/{guest}', [GuestController::class, 'destroy']);

//     Route::get('/rooms', [RoomController::class, 'index']);

//     // Events
//     Route::view('events', 'pages.event.index');

//     // booking
//     Route::get('/bookings', [BookingController::class, 'index']);
//     Route::view('/show-booking', 'pages.booking.show');
//     Route::view('/book', 'pages.booking.booking');
//     Route::get('/booking/result/{booking}', [BookingController::class, 'show']);
//     Route::get('/booking/check-in/{booking}', [BookingController::class, 'checkIn']);
//     Route::get('/booking/check-out/{booking}', [BookingController::class, 'checkOut']);
    
// });


// Route::middleware(['auth', 'role:staff'])->group(function () {
//     // Rooms
//     Route::get('/rooms', [RoomController::class, 'index']);

//     // Events
//     Route::view('events', 'pages.event.index');

//     // booking
//     Route::get('/bookings', [BookingController::class, 'index']);
//     Route::view('/show-booking', 'pages.booking.show');
//     Route::view('/book', 'pages.booking.booking');
//     Route::get('/booking/result/{booking}', [BookingController::class, 'show']);
//     Route::get('/booking/check-in/{booking}', [BookingController::class, 'checkIn']);
//     Route::get('/booking/check-out/{booking}', [BookingController::class, 'checkOut']);

//     // Guests
//     Route::get('/guests', [GuestController::class, 'index']);
//     Route::get('/guest/edit/{guest}', [GuestController::class, 'edit']);
//     Route::put('/guest/update/{guest}', [GuestController::class, 'update'])->name('guest.update');
//     Route::delete('/guest/delete/{guest}', [GuestController::class, 'destroy']);

//     // 
//     Route::get('/guest/search', function (\Illuminate\Http\Request $request) {
//         return \App\Models\Guest::query()
//             ->when($request->search, function ($q) use ($request) {
//                 $search = $request->search;

//                 $q->where(function ($query) use ($search) {
//                     $query->where('first_name', 'like', "%{$search}%")
//                         ->orWhere('last_name', 'like', "%{$search}%")
//                         ->orWhereRaw("first_name || ' ' || last_name LIKE ?", ["%{$search}%"]);
//                 });
//             })
//             ->limit(10)
//             ->get()
//             ->map(fn ($guest) => [
//                 'id' => $guest->id,
//                 'label' => $guest->first_name . ' ' . $guest->last_name,
//             ]);
//     })->name('guest.search');
// });


Route::middleware(['auth', 'role:admin,housekeeping'])->group(function () {
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::view('/events', 'pages.event.index')->name('events.index');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
    Route::view('/show-booking', 'pages.booking.show')->name('booking.show-page');
    Route::view('/book', 'pages.booking.booking')->name('booking.book-page');
    Route::get('/booking/result/{booking}', [BookingController::class, 'show'])->name('booking.result');
    Route::get('/booking/check-in/{booking}', [BookingController::class, 'checkIn'])->name('booking.check-in');
    Route::get('/booking/check-out/{booking}', [BookingController::class, 'checkOut'])->name('booking.check-out');
    Route::patch('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    Route::get('/guests', [GuestController::class, 'index'])->name('guests');
    Route::get('/guest/edit/{guest}', [GuestController::class, 'edit'])->name('guest.edit');
    Route::put('/guest/update/{guest}', [GuestController::class, 'update'])->name('guest.update');

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




    // CHECK IN
Route::get('/check-in/{booking}', [CheckInController::class, 'show'])->name('check-in.show');
Route::post('/booking/{booking}/payment', [CheckInController::class, 'store'])->name('booking.payment.store');
// CHECK OUT
Route::get('/check-out/{booking}', [CheckOutController::class, 'show'])->name('hms.check-out.show');
Route::post('/hms/check-out/{booking}', [CheckOutController::class, 'store'])->name('hms.check-out.store');
// INVOICES
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/{booking}', [InvoiceController::class, 'show'])->name('invoices.show');
// REPORT
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// HOUSEKEEPING
Route::get('/housekeeping', [HousekeepingTaskController::class, 'index'])->name('housekeeping.index');
Route::post('/housekeeping/tasks', [HousekeepingTaskController::class, 'store'])->name('housekeeping.tasks.store');
Route::patch('/housekeeping/tasks/{task}', [HousekeepingTaskController::class, 'update'])->name('housekeeping.tasks.update');
    
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::view('/dashboard', 'pages.dashboard.index')->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::view('/invoices', 'pages.invoices.index')->name('invoices');

    Route::get('/room-type', [RoomTypeController::class, 'index'])->name('room-type.index');
    Route::delete('/rooms/delete/{roomType}', [RoomTypeController::class, 'destroy'])->name('room-type.delete');

    Route::delete('/guest/delete/{guest}', [GuestController::class, 'destroy'])->name('guest.delete');

    // NIGHT AUDIT
    Route::get('/night-audit', [NightAuditController::class, 'index'])->name('night-audit.index');
    Route::post('/night-audit/run', [NightAuditController::class, 'run'])->name('night-audit.run');
    Route::get('/night-audit/history', [NightAuditController::class, 'history'])->name('night-audit.history');
    Route::get('/night-audit/{nightAudit}', [NightAuditController::class, 'show'])->name('night-audit.show');

    // ACCOUNT CREATION

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::patch('/admin/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
});




// Housekeeping
// Route::get('/housekeeping', [HousekeepingController::class, 'index'])->name('housekeeping.index');
// Route::patch('/housekeeping/{room}/start-cleaning', [HousekeepingController::class, 'startCleaning'])->name('housekeeping.start-cleaning');
// Route::patch('/housekeeping/{room}/mark-clean', [HousekeepingController::class, 'markClean'])->name('housekeeping.mark-clean');
// Route::patch('/housekeeping/{room}/mark-maintenance', [HousekeepingController::class, 'markMaintenance'])->name('housekeeping.mark-maintenance');
// Route::patch('/housekeeping/{room}/mark-dirty', [HousekeepingController::class, 'markDirty'])->name('housekeeping.mark-dirty');




require __DIR__.'/auth.php';

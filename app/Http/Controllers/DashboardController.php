<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $arrivalsToday = Booking::with('guest')
            ->whereDate('check_in_date', $today)
            ->count();

        $departuresToday = Booking::with('guest')
            ->whereDate('check_out_date', $today)
            ->count();

        $inHouseGuests = Booking::where('status', 'checked_in')->count();

        $availableRooms = Room::where('status', 'Available')->count();
        $occupiedRooms = Room::where('status', 'Occupied')->count();
        $dirtyRooms = Room::where('status', 'Dirty')->count();
        $cleaningRooms = Room::where('status', 'Cleaning')->count();
        $maintenanceRooms = Room::where('status', 'Maintenance')->count();

        $todayRevenue = Payment::whereDate('payment_date', $today)->sum('amount');
        $outstandingBalance = Booking::where('balance', '>', 0)->sum('balance');

        $recentBookings = Booking::with(['guest', 'rooms.roomType'])
            ->latest()
            ->take(5)
            ->get();

        $pendingCheckIns = Booking::with('guest')
            ->whereDate('check_in_date', $today)
            ->whereIn('status', ['reserved', 'confirmed'])
            ->take(5)
            ->get();

        $pendingCheckOuts = Booking::with('guest')
            ->whereDate('check_out_date', $today)
            ->where('status', 'checked_in')
            ->take(5)
            ->get();


            // TOTAL ROOMS
            $totalRooms = Room::count();

            // OCCUPIED ROOMS
            $occupiedRooms = Room::where('status', 'Occupied')->count();

            // OCCUPANCY RATE
            $occupancyRate = $totalRooms > 0
                ? round(($occupiedRooms / $totalRooms) * 100, 2)
                : 0;


            // ROOM STATUS CHART
            $roomStatusData = [
                'labels' => ['Available', 'Occupied', 'Dirty', 'Cleaning', 'Maintenance'],
                'data' => [
                    Room::where('status', 'Available')->count(),
                    Room::where('status', 'Occupied')->count(),
                    Room::where('status', 'Dirty')->count(),
                    Room::where('status', 'Cleaning')->count(),
                    Room::where('status', 'Maintenance')->count(),
                ],
            ];


            // MONTHLY REVENUE (last 6 months)
            $monthlyRevenueRaw = DB::table('payments')
                ->selectRaw("strftime('%m-%Y', payment_date) as month, SUM(amount) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $monthlyRevenue = [
                'labels' => $monthlyRevenueRaw->pluck('month'),
                'data' => $monthlyRevenueRaw->pluck('total'),
            ];
            

        return view('pages.dashboard.index', compact(
            'today',
            'arrivalsToday',
            'departuresToday',
            'inHouseGuests',
            'availableRooms',
            'occupiedRooms',
            'dirtyRooms',
            'cleaningRooms',
            'maintenanceRooms',
            'todayRevenue',
            'outstandingBalance',
            'recentBookings',
            'pendingCheckIns',
            'pendingCheckOuts',
            'occupancyRate',
            'roomStatusData',
            'monthlyRevenue'
        ));
    }
}
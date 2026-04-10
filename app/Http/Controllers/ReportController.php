<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('guest')->latest();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('check_in_date', [$request->from, $request->to]);
        }

        $bookings = $query->get();

        $totalRevenue = $bookings->sum('paid_amount');
        $totalBookings = $bookings->count();
        $checkedIn = $bookings->where('status', 'checked_in')->count();
        $checkedOut = $bookings->where('status', 'checked_out')->count();

        $paid = $bookings->where('payment_status', 'paid')->count();
        $partial = $bookings->where('payment_status', 'partial')->count();
        $unpaid = $bookings->where('payment_status', 'unpaid')->count();

        // Revenue chart by check-in month
        $monthlyRevenue = $bookings
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->check_in_date)->format('M Y');
            })
            ->map(function ($group) {
                return round($group->sum('paid_amount'), 2);
            });

        // Booking status chart
        $bookingStatusData = [
            'Reserved' => $bookings->where('status', 'reserved')->count(),
            'Confirmed' => $bookings->where('status', 'confirmed')->count(),
            'Checked In' => $bookings->where('status', 'checked_in')->count(),
            'Checked Out' => $bookings->where('status', 'checked_out')->count(),
            'Cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        // Payment status chart
        $paymentStatusData = [
            'Paid' => $paid,
            'Partial' => $partial,
            'Unpaid' => $unpaid,
        ];

        return view('pages.reports.index', compact(
            'bookings',
            'totalRevenue',
            'totalBookings',
            'checkedIn',
            'checkedOut',
            'paid',
            'partial',
            'unpaid',
            'monthlyRevenue',
            'bookingStatusData',
            'paymentStatusData'
        ));
    }
}
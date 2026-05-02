<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\NightAudit;
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

        $monthlyRevenue = $bookings
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->check_in_date)->format('M Y');
            })
            ->map(function ($group) {
                return round($group->sum('paid_amount'), 2);
            });

        $bookingStatusData = [
            'Reserved' => $bookings->where('status', 'reserved')->count(),
            'Confirmed' => $bookings->where('status', 'confirmed')->count(),
            'Checked In' => $bookings->where('status', 'checked_in')->count(),
            'Checked Out' => $bookings->where('status', 'checked_out')->count(),
            'Cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

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

    public function weekly(Request $request)
    {
        $start = $request->filled('from')
            ? Carbon::parse($request->from)->startOfDay()
            : now()->startOfWeek();

        $end = $request->filled('to')
            ? Carbon::parse($request->to)->endOfDay()
            : now()->endOfWeek();

        $audits = NightAudit::with('user')
            ->whereBetween('audit_date', [
                $start->toDateString(),
                $end->toDateString(),
            ])
            ->orderBy('audit_date')
            ->get();

        $totalReservations = $audits->sum('total_reservations');
        $totalCancellations = $audits->sum('total_cancellations');
        $totalPayments = $audits->sum('total_payments');

        $grossSales = $audits->sum('daily_revenue');
        $vatableSales = $audits->sum('vatable_sales');
        $vatAmount = $audits->sum('vat_amount');
        $netSales = $audits->sum('net_sales');

        $totalArrivals = $audits->sum('arrivals_count');
        $totalDepartures = $audits->sum('departures_count');
        $totalOutstandingBalance = $audits->sum('outstanding_balance');

        $chartLabels = $audits->map(function ($audit) {
            return $audit->audit_date->format('M d');
        })->values();

        $revenueChartData = $audits->map(function ($audit) {
            return (float) $audit->daily_revenue;
        })->values();

        $vatChartData = $audits->map(function ($audit) {
            return (float) $audit->vat_amount;
        })->values();

        return view('pages.reports.weekly', compact(
            'start',
            'end',
            'audits',
            'totalReservations',
            'totalCancellations',
            'totalPayments',
            'grossSales',
            'vatableSales',
            'vatAmount',
            'netSales',
            'totalArrivals',
            'totalDepartures',
            'totalOutstandingBalance',
            'chartLabels',
            'revenueChartData',
            'vatChartData'
        ));
    }
}
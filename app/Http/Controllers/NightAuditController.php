<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\NightAudit;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NightAuditController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $data = $this->buildAuditSnapshot($today);

        $latestAudit = NightAudit::latest('audit_date')->first();

        return view('pages.night-audit.index', [
            'today' => $today,
            'latestAudit' => $latestAudit,
            ...$data,
        ]);
    }

    public function run(Request $request)
    {
        $auditDate = $request->filled('audit_date')
            ? Carbon::parse($request->audit_date)->startOfDay()
            : Carbon::today();

        return DB::transaction(function () use ($auditDate) {
            $existing = NightAudit::whereDate('audit_date', $auditDate)->lockForUpdate()->first();

            if ($existing) {
                return redirect()
                    ->route('night-audit.index')
                    ->with('error', 'Night audit for this date has already been completed.');
            }

            $data = $this->buildAuditSnapshot($auditDate);

            $summary = [
                'pending_checkins' => $data['pendingCheckIns']->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'booking_code' => $booking->booking_code,
                        'guest' => optional($booking->guest)->first_name . ' ' . optional($booking->guest)->last_name,
                        'status' => $booking->status,
                        'check_in_date' => optional($booking->check_in_date)->format('Y-m-d'),
                    ];
                })->values()->toArray(),

                'pending_checkouts' => $data['pendingCheckOuts']->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'booking_code' => $booking->booking_code,
                        'guest' => optional($booking->guest)->first_name . ' ' . optional($booking->guest)->last_name,
                        'status' => $booking->status,
                        'balance' => (float) $booking->balance,
                        'check_out_date' => optional($booking->check_out_date)->format('Y-m-d'),
                    ];
                })->values()->toArray(),

                'unsettled_accounts' => $data['unsettledAccounts']->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'booking_code' => $booking->booking_code,
                        'guest' => optional($booking->guest)->first_name . ' ' . optional($booking->guest)->last_name,
                        'status' => $booking->status,
                        'balance' => (float) $booking->balance,
                    ];
                })->values()->toArray(),
            ];

            NightAudit::create([
                'audit_date' => $auditDate->toDateString(),
                'arrivals_count' => $data['arrivalsToday'],
                'departures_count' => $data['departuresToday'],
                'in_house_count' => $data['inHouseGuests'],
                'occupied_rooms' => $data['occupiedRooms'],
                'available_rooms' => $data['availableRooms'],
                'daily_revenue' => $data['dailyRevenue'],
                'outstanding_balance' => $data['outstandingBalances'],
                'pending_checkins_count' => $data['pendingCheckIns']->count(),
                'pending_checkouts_count' => $data['pendingCheckOuts']->count(),
                'unsettled_accounts_count' => $data['unsettledAccounts']->count(),
                'summary' => $summary,
                'audited_at' => now(),
                'status' => 'completed',
                'audited_by' => Auth::id(),
            ]);

            return redirect()
                ->route('night-audit.index')
                ->with('success', 'Night audit completed successfully.');
        });
    }

    public function history()
    {
        $audits = NightAudit::with('user')
            ->latest('audit_date')
            ->paginate(10);

        return view('pages.night-audit.history', compact('audits'));
    }

    private function buildAuditSnapshot(Carbon $date): array
    {
        $arrivalsToday = Booking::whereDate('check_in_date', $date)->count();

        $departuresToday = Booking::whereDate('check_out_date', $date)->count();

        $inHouseGuests = Booking::where('status', 'checked_in')->count();

        $occupiedRooms = Room::where('status', 'Occupied')->count();

        $availableRooms = Room::where('status', 'Available')->count();

        // Better than updated_at for many systems would be payments sum for that day,
        // but using booking paid updates is okay if that's how your app tracks revenue.
        $dailyRevenue = Booking::whereDate('updated_at', $date)->sum('paid_amount');

        $outstandingBalances = Booking::where('balance', '>', 0)->sum('balance');

        $pendingCheckIns = Booking::with('guest')
            ->whereDate('check_in_date', $date)
            ->whereIn('status', ['reserved', 'confirmed'])
            ->get();

        $pendingCheckOuts = Booking::with('guest')
            ->whereDate('check_out_date', $date)
            ->where('status', 'checked_in')
            ->get();

        $unsettledAccounts = Booking::with('guest')
            ->where('balance', '>', 0)
            ->get();

        return compact(
            'arrivalsToday',
            'departuresToday',
            'inHouseGuests',
            'occupiedRooms',
            'availableRooms',
            'dailyRevenue',
            'outstandingBalances',
            'pendingCheckIns',
            'pendingCheckOuts',
            'unsettledAccounts'
        );
    }

    public function show(\App\Models\NightAudit $nightAudit)
    {
        return view('pages.night-audit.show', compact('nightAudit'));
    }
}
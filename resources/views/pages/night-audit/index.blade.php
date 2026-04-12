<x-layouts.layout>

    @if (session('success'))
    <x-notification :message="session('success')" type="success" />
    @endif

    @if (session('error'))
        <x-notification :message="session('error')" type="error" />
    @endif
    
    <div class="min-h-screen">
        <div class="">

            <!-- Header -->
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Operations • Night Audit
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Night Audit
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 sm:text-base">
                        End-of-day review of occupancy, balances, departures, and revenue.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="/night-audit/history"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        History
                    </a>

                    <button onclick="window.print()"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Print Report
                    </button>

                    <form action="{{ route('night-audit.run') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="audit_date" value="{{ $today->format('Y-m-d') }}">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                            Run Night Audit
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Audit Date</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $today->format('M d, Y') }}</h3>
                    <p class="mt-4 text-xs text-slate-400">Current business day under review</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Daily Revenue</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">₱{{ number_format($dailyRevenue, 2) }}</h3>
                    <p class="mt-4 text-xs text-slate-400">Payments recorded for today</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Occupied Rooms</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">{{ $occupiedRooms }}</h3>
                    <p class="mt-4 text-xs text-slate-400">Rooms currently in use</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Outstanding Balance</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-rose-600">₱{{ number_format($outstandingBalances, 2) }}</h3>
                    <p class="mt-4 text-xs text-slate-400">Unsettled guest balances</p>
                </div>
            </div>

            <!-- Operational cards -->
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Arrivals Today</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $arrivalsToday }}</h3>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Departures Today</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $departuresToday }}</h3>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">In-House Guests</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $inHouseGuests }}</h3>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Available Rooms</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $availableRooms }}</h3>
                </div>
            </div>

            <!-- Main Grids -->
            <div class="grid grid-cols-3 gap-5">
                <div class="xl:col-span-6 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Pending Check-Ins</h2>
                    <p class="mt-1 text-sm text-slate-500">Bookings expected today but not yet fully processed.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($pendingCheckIns as $booking)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $booking->booking_code }} • {{ ucfirst($booking->status) }}</p>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                No pending check-ins.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="xl:col-span-6 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Pending Check-Outs</h2>
                    <p class="mt-1 text-sm text-slate-500">In-house guests scheduled for departure today.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($pendingCheckOuts as $booking)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $booking->booking_code }} • Balance: ₱{{ number_format($booking->balance, 2) }}</p>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                No pending check-outs.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="xl:col-span-12 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Unsettled Accounts</h2>
                    <p class="mt-1 text-sm text-slate-500">Guests with remaining balances requiring attention before closing the day.</p>

                    <div class="mt-5 overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Guest</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Booking Code</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse($unsettledAccounts as $booking)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-slate-900">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ $booking->booking_code }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</td>
                                        <td class="px-4 py-3 text-sm font-semibold text-amber-600">₱{{ number_format($booking->balance, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-500">
                                            No unsettled accounts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
@media print {
    @page {
        size: A4;
        margin: 12mm;
    }

    button {
        display: none !important;
    }

    html, body {
        background: white !important;
    }

    .shadow-sm {
        box-shadow: none !important;
    }

    .rounded-\[28px\],
    .rounded-\[30px\] {
        border-radius: 0 !important;
    }
}
</style>
</x-layouts.layout>
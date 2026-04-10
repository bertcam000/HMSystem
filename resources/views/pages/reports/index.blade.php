<x-layouts.layout>


<div class="min-h-screen ">
    <div class="">

        @php
            $from = request('from');
            $to = request('to');
        @endphp

        <!-- Header -->
        <div class="mb-8">
            <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                Analytics • Reports
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Reports
            </h1>
            <p class="mt-1 text-sm text-slate-500 sm:text-base">
                Review booking performance, revenue trends, and payment summaries.
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Revenue</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                            ₱{{ number_format($totalRevenue, 2) }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v12m6-9H9.75a2.25 2.25 0 1 1 0-4.5H15a2.25 2.25 0 1 1 0 4.5H9a2.25 2.25 0 1 0 0 4.5H18" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Collected payments within the selected period</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Bookings</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                            {{ $totalBookings }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8.25 6.75h12m-12 4.5h12m-12 4.5h12m-16.5-9h.008v.008H3.75V6.75Zm0 4.5h.008v.008H3.75v-.008Zm0 4.5h.008v.008H3.75v-.008Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">All bookings included in this report</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Checked In</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">
                            {{ $checkedIn }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 6.75v10.5m-7.5-10.5v10.5m-3-13.5h13.5A2.25 2.25 0 0 1 21 6v12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V6a2.25 2.25 0 0 1 2.25-2.25Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Guests currently marked as checked in</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Checked Out</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-rose-600">
                            {{ $checkedOut }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Completed guest departures</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 rounded-[30px] border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                <div class="xl:col-span-4">
                    <label class="mb-2 block text-sm font-medium text-slate-700">From</label>
                    <input
                        type="date"
                        name="from"
                        value="{{ $from }}"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>

                <div class="xl:col-span-4">
                    <label class="mb-2 block text-sm font-medium text-slate-700">To</label>
                    <input
                        type="date"
                        name="to"
                        value="{{ $to }}"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>

                <div class="xl:col-span-4">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Quick Action</label>
                    <div class="flex gap-3">
                        <a
                            href="{{ route('reports.index') }}"
                            class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Reset
                        </a>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                        >
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Charts -->
        <div class="mb-8 grid grid-cols-1 gap-6 xl:grid-cols-12">
            <div class="xl:col-span-7 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-slate-900">Revenue Trend</h2>
                    <p class="mt-1 text-sm text-slate-500">Revenue grouped by booking check-in month.</p>
                </div>
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="xl:col-span-5 space-y-6">
                <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-slate-900">Booking Status</h2>
                        <p class="mt-1 text-sm text-slate-500">Distribution of booking lifecycle statuses.</p>
                    </div>
                    <div class="h-64">
                        <canvas id="bookingStatusChart"></canvas>
                    </div>
                </div>

                <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-slate-900">Payment Status</h2>
                        <p class="mt-1 text-sm text-slate-500">Breakdown of payment completion.</p>
                    </div>
                    <div class="h-64">
                        <canvas id="paymentStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-[30px] border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Guest</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Booking Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Stay</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Paid</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Balance</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Payment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($bookings as $booking)
                            @php
                                $guest = $booking->guest;
                                $guestInitials = strtoupper(
                                    substr($guest->first_name ?? '', 0, 1) .
                                    substr($guest->last_name ?? '', 0, 1)
                                );

                                $paymentStatus = strtolower($booking->payment_status);
                                $bookingStatus = strtolower($booking->status);
                            @endphp

                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">
                                            {{ $guestInitials ?: 'GU' }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">
                                                {{ $guest->first_name }} {{ $guest->last_name }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ $guest->email ?: 'No email provided' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                    {{ $booking->booking_code }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <div>{{ $booking->check_in_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-slate-400">to {{ $booking->check_out_date->format('M d, Y') }}</div>
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    ₱{{ number_format($booking->total_price, 2) }}
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-emerald-600">
                                    ₱{{ number_format($booking->paid_amount, 2) }}
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold {{ (float) $booking->balance > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                                    ₱{{ number_format($booking->balance, 2) }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($paymentStatus === 'paid')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            Paid
                                        </span>
                                    @elseif ($paymentStatus === 'partial')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                            Partial
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                            Unpaid
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if ($bookingStatus === 'checked_out')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                            Checked Out
                                        </span>
                                    @elseif ($bookingStatus === 'checked_in')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            Checked In
                                        </span>
                                    @elseif ($bookingStatus === 'confirmed')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                            <span class="h-2 w-2 rounded-full bg-sky-500"></span>
                                            Confirmed
                                        </span>
                                    @elseif ($bookingStatus === 'reserved')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700">
                                            <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                                            Reserved
                                        </span>
                                    @elseif ($bookingStatus === 'cancelled')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                                            <span class="h-2 w-2 rounded-full bg-slate-500"></span>
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                            <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M8.25 6.75h12m-12 4.5h12m-12 4.5h12m-16.5-9h.008v.008H3.75V6.75Zm0 4.5h.008v.008H3.75v-.008Zm0 4.5h.008v.008H3.75v-.008Z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-sm font-semibold text-slate-900">No report data found</h3>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Try adjusting the selected date range.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-end print:hidden">
            <button onclick="window.print()"
                class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                Print Report
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueLabels = @json(array_keys($monthlyRevenue->toArray()));
    const revenueData = @json(array_values($monthlyRevenue->toArray()));

    const bookingStatusLabels = @json(array_keys($bookingStatusData));
    const bookingStatusValues = @json(array_values($bookingStatusData));

    const paymentStatusLabels = @json(array_keys($paymentStatusData));
    const paymentStatusValues = @json(array_values($paymentStatusData));

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(document.getElementById('bookingStatusChart'), {
        type: 'doughnut',
        data: {
            labels: bookingStatusLabels,
            datasets: [{
                data: bookingStatusValues,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('paymentStatusChart'), {
        type: 'pie',
        data: {
            labels: paymentStatusLabels,
            datasets: [{
                data: paymentStatusValues,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

<style>
@media print {
    @page {
        size: A4;
        margin: 12mm;
    }

    .print\:hidden,
    form,
    button,
    script,
    canvas + * {
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
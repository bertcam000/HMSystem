<x-layouts.layout>
    @if (session('success'))
        <x-notification :message="session('success')" type="success" />
    @endif

    <div class="min-h-screen">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between print:hidden">
            <div>
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    Reports & Compliance • Weekly Summary
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Weekly Compliance Report
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $start->format('M d, Y') }} - {{ $end->format('M d, Y') }}
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('reports.index') }}"
                   class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Back to Reports
                </a>

                <button onclick="window.print()"
                    class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700">
                    Print Report
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('reports.weekly') }}"
              class="mb-8 grid gap-4 rounded-[30px] border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-3 print:hidden">
            <div>
                <label class="text-sm font-semibold text-slate-700">From</label>
                <input type="date" name="from" value="{{ request('from', $start->toDateString()) }}"
                       class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">To</label>
                <input type="date" name="to" value="{{ request('to', $end->toDateString()) }}"
                       class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
            </div>

            <div class="flex items-end">
                <button class="w-full rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700">
                    Generate
                </button>
            </div>
        </form>

        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Gross Sales</p>
                <h3 class="mt-2 text-3xl font-bold text-emerald-600">₱{{ number_format($grossSales, 2) }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">VAT Amount</p>
                <h3 class="mt-2 text-3xl font-bold text-amber-600">₱{{ number_format($vatAmount, 2) }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Reservations</p>
                <h3 class="mt-2 text-3xl font-bold text-slate-900">{{ $totalReservations }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Cancellations</p>
                <h3 class="mt-2 text-3xl font-bold text-rose-600">{{ $totalCancellations }}</h3>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">VATable Sales</p>
                <h3 class="mt-2 text-2xl font-bold text-slate-900">₱{{ number_format($vatableSales, 2) }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Net Sales</p>
                <h3 class="mt-2 text-2xl font-bold text-slate-900">₱{{ number_format($netSales, 2) }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Arrivals</p>
                <h3 class="mt-2 text-2xl font-bold text-slate-900">{{ $totalArrivals }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Departures</p>
                <h3 class="mt-2 text-2xl font-bold text-slate-900">{{ $totalDepartures }}</h3>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-5 xl:grid-cols-2 print:hidden">
            <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900">Revenue Trend</h2>
                <canvas id="revenueChart" class="mt-5"></canvas>
            </div>

            <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900">VAT Trend</h2>
                <canvas id="vatChart" class="mt-5"></canvas>
            </div>
        </div>

        <div class="overflow-hidden rounded-[30px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900">Daily Night Audit Breakdown</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Weekly data is generated from completed Night Audit snapshots.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Reservations</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Cancellations</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Gross Sales</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">VATable Sales</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">VAT</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Net Sales</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">Audited By</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($audits as $audit)
                            <tr>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    {{ $audit->audit_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $audit->total_reservations }}</td>
                                <td class="px-6 py-4 text-sm text-rose-600 font-semibold">{{ $audit->total_cancellations }}</td>
                                <td class="px-6 py-4 text-sm text-emerald-600 font-semibold">₱{{ number_format($audit->daily_revenue, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">₱{{ number_format($audit->vatable_sales, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-amber-600 font-semibold">₱{{ number_format($audit->vat_amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">₱{{ number_format($audit->net_sales, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $audit->user->name ?? 'System' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">
                                    No completed night audits found for this week.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json($chartLabels);
        const revenueData = @json($revenueChartData);
        const vatData = @json($vatChartData);

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    tension: 0.35
                }]
            }
        });

        new Chart(document.getElementById('vatChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'VAT Amount',
                    data: vatData
                }]
            }
        });
    </script>
</x-layouts.layout>
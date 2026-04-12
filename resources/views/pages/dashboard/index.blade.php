<x-layouts.layout>

    <div class="min-h-screen ">
        <div class="">

            <!-- Header -->
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Operations • Dashboard
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Dashboard
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 sm:text-base">
                        Overview of hotel activity, room operations, and today’s front desk performance.
                    </p>
                </div>

                <div class="rounded-[24px] border border-slate-200 bg-white px-5 py-4 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Today</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $today->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Main Summary Cards -->
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Arrivals Today</p>
                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $arrivalsToday }}</h3>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12m-12 4.5h12m-12 4.5h12m-16.5-9h.008v.008H3.75V6.75Zm0 4.5h.008v.008H3.75v-.008Zm0 4.5h.008v.008H3.75v-.008Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-slate-400">Guests expected to arrive today</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Departures Today</p>
                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $departuresToday }}</h3>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-slate-400">Guests expected to leave today</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">In-House Guests</p>
                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">{{ $inHouseGuests }}</h3>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75v10.5m-7.5-10.5v10.5m-3-13.5h13.5A2.25 2.25 0 0 1 21 6v12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V6a2.25 2.25 0 0 1 2.25-2.25Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-slate-400">Guests currently staying in-house</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Today Revenue</p>
                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">₱{{ number_format($todayRevenue, 2) }}</h3>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-9H9.75a2.25 2.25 0 1 1 0-4.5H15a2.25 2.25 0 1 1 0 4.5H9a2.25 2.25 0 1 0 0 4.5H18" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-slate-400">Payments collected today</p>
                </div>
            </div>

            <!-- Room Status Cards -->
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Available</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">{{ $availableRooms }}</h3>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Occupied</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-rose-600">{{ $occupiedRooms }}</h3>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Dirty</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">{{ $dirtyRooms }}</h3>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Cleaning</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-sky-600">{{ $cleaningRooms }}</h3>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm text-center">
                    <p class="text-sm font-medium text-slate-500">Maintenance</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-700">{{ $maintenanceRooms }}</h3>
                </div>
            </div>

            <!-- Secondary Overview -->
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Outstanding Balance</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">
                        ₱{{ number_format($outstandingBalance, 2) }}
                    </h3>
                    <p class="mt-4 text-xs text-slate-400">Remaining balances across active bookings</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Quick Actions</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('housekeeping.index') }}" class="rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                            Housekeeping
                        </a>
                        <a href="{{ route('night-audit.index') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Night Audit
                        </a>
                        <a href="{{ route('reports.index') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Reports
                        </a>
                        <a href="{{ route('invoices.index') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Invoices
                        </a>
                    </div>
                </div>
            </div>



            {{--  --}}
            <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-12">

                <!-- Occupancy Rate -->
                <div class="xl:col-span-4 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Occupancy Rate</h2>

                    <div class="mt-6 flex items-center justify-center">
                        <div class="relative h-40 w-40">
                            <canvas id="occupancyChart"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xl font-bold text-slate-900">
                                    {{ $occupancyRate }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 text-center text-sm text-slate-500">
                        Percentage of rooms currently occupied
                    </p>
                </div>


                <!-- Room Status Chart -->
                <div class="xl:col-span-4 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Room Status Overview</h2>

                    <div class="mt-6 h-40">
                        <canvas id="roomStatusChart"></canvas>
                    </div>
                </div>


                <!-- Monthly Revenue -->
                <div class="xl:col-span-4 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Monthly Revenue</h2>

                    <div class="mt-6 h-40">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

            </div>
            {{--  --}}
            
            

            <!-- Main Grid -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12 mt-7">

                <!-- Pending Check-Ins -->
                <div class="xl:col-span-4 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Pending Check-Ins</h2>
                    <p class="mt-1 text-sm text-slate-500">Expected arrivals still awaiting completion.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($pendingCheckIns as $booking)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $booking->guest->first_name }} {{ $booking->guest->last_name }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $booking->booking_code }} • {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </p>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
                                <p class="text-sm text-slate-500">No pending check-ins today.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pending Check-Outs -->
                <div class="xl:col-span-4 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Pending Check-Outs</h2>
                    <p class="mt-1 text-sm text-slate-500">Guests due to depart today.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($pendingCheckOuts as $booking)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $booking->guest->first_name }} {{ $booking->guest->last_name }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $booking->booking_code }} • Balance: ₱{{ number_format($booking->balance, 2) }}
                                </p>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
                                <p class="text-sm text-slate-500">No pending check-outs today.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="xl:col-span-4 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Recent Bookings</h2>
                    <p class="mt-1 text-sm text-slate-500">Latest booking activity in the system.</p>

                    <div class="mt-5 space-y-3">
                        @forelse($recentBookings as $booking)
                            @php
                                $room = $booking->rooms->first();
                            @endphp
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $booking->guest->first_name }} {{ $booking->guest->last_name }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $booking->booking_code }}
                                    @if($room)
                                        • Room {{ $room->room_number }}
                                    @endif
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </p>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
                                <p class="text-sm text-slate-500">No recent bookings found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            
            
        </div>
        
        
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
    function formatPeso(value) {
        return '₱' + Number(value || 0).toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function formatNumber(value) {
        return Number(value || 0).toLocaleString('en-PH');
    }

    // OCCUPANCY CHART
    const occupancyCanvas = document.getElementById('occupancyChart');
    if (occupancyCanvas) {
        new Chart(occupancyCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Occupied', 'Available'],
                datasets: [{
                    data: [{{ $occupancyRate }}, {{ 100 - $occupancyRate }}],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                const value = Number(context.parsed || 0);
                                return context.label + ': ' + value.toLocaleString('en-PH', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    // ROOM STATUS CHART
    const roomStatusCanvas = document.getElementById('roomStatusChart');
    if (roomStatusCanvas) {
        new Chart(roomStatusCanvas, {
            type: 'bar',
            data: {
                labels: @json($roomStatusData['labels']),
                datasets: [{
                    data: @json($roomStatusData['data']),
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
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rooms: ' + formatNumber(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#64748b',
                            callback: function(value) {
                                return formatNumber(value);
                            }
                        }
                    }
                }
            }
        });
    }

    // MONTHLY REVENUE CHART
    const revenueCanvas = document.getElementById('revenueChart');
    if (revenueCanvas) {
        new Chart(revenueCanvas, {
            type: 'line',
            data: {
                labels: @json($monthlyRevenue['labels']),
                datasets: [{
                    label: 'Revenue',
                    data: @json($monthlyRevenue['data']),
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: ' + formatPeso(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#64748b',
                            callback: function(value) {
                                return formatPeso(value);
                            }
                        }
                    }
                }
            }
        });
    }
</script>
</x-layouts.layout>
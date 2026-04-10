<x-layouts.layout>

<div class="min-h-screen">
    <div class="">

        @php
            $summary = $nightAudit->summary ?? [];

            $pendingCheckins = $summary['pending_checkins'] ?? [];
            $pendingCheckouts = $summary['pending_checkouts'] ?? [];
            $unsettledAccounts = $summary['unsettled_accounts'] ?? [];
        @endphp

        <!-- Top Action Bar -->
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between print:hidden">
            <div>
                <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    Operations • Audit Snapshot
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Night Audit Snapshot
                </h1>
                <p class="mt-1 text-sm text-slate-500 sm:text-base">
                    Review the saved operational summary for {{ $nightAudit->audit_date->format('M d, Y') }}.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('night-audit.history') }}"
                   class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    ← Back to History
                </a>

                <button onclick="window.print()"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                    Print Snapshot
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Audit Date</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                            {{ $nightAudit->audit_date->format('M d, Y') }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8.25 6.75h12m-12 4.5h12m-12 4.5h12m-16.5-9h.008v.008H3.75V6.75Zm0 4.5h.008v.008H3.75v-.008Zm0 4.5h.008v.008H3.75v-.008Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Business day captured by this audit</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Revenue</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">
                            ₱{{ number_format($nightAudit->daily_revenue, 2) }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v12m6-9H9.75a2.25 2.25 0 1 1 0-4.5H15a2.25 2.25 0 1 1 0 4.5H9a2.25 2.25 0 1 0 0 4.5H18" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Revenue snapshot recorded during audit</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Outstanding Balance</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">
                            ₱{{ number_format($nightAudit->outstanding_balance, 2) }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8.25v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Unsettled balances at the time of audit</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Audited At</p>
                        <h3 class="mt-2 text-lg font-bold tracking-tight text-slate-900">
                            {{ optional($nightAudit->audited_at)->format('M d, Y h:i A') }}
                        </h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">
                    {{ $nightAudit->user->name ?? 'System' }}
                </p>
            </div>
        </div>

        <!-- Operational cards -->
        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200 bg-white p-5 text-center shadow-sm">
                <p class="text-sm font-medium text-slate-500">Arrivals</p>
                <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $nightAudit->arrivals_count }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 text-center shadow-sm">
                <p class="text-sm font-medium text-slate-500">Departures</p>
                <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $nightAudit->departures_count }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 text-center shadow-sm">
                <p class="text-sm font-medium text-slate-500">In-House</p>
                <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $nightAudit->in_house_count }}</h3>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 text-center shadow-sm">
                <p class="text-sm font-medium text-slate-500">Rooms</p>
                <h3 class="mt-2 text-lg font-bold tracking-tight text-slate-900">
                    {{ $nightAudit->occupied_rooms }} Occupied / {{ $nightAudit->available_rooms }} Available
                </h3>
            </div>
        </div>

        <!-- Detailed Sections -->
        <div class="grid grid-cols-3 gap-4">

            <div class="xl:col-span-6 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900">Pending Check-Ins Snapshot</h2>
                <p class="mt-1 text-sm text-slate-500">Bookings still pending at the time this audit was saved.</p>

                <div class="mt-5 space-y-3">
                    @forelse($pendingCheckins as $item)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm font-semibold text-slate-900">{{ $item['guest'] ?? 'Unknown Guest' }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ $item['booking_code'] ?? '—' }} • {{ ucfirst($item['status'] ?? '—') }}
                            </p>
                            <p class="mt-1 text-xs text-slate-400">
                                Check-In Date: {{ $item['check_in_date'] ?? '—' }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                            No pending check-ins in this snapshot.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="xl:col-span-6 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900">Pending Check-Outs Snapshot</h2>
                <p class="mt-1 text-sm text-slate-500">Checked-in bookings still due for departure at audit time.</p>

                <div class="mt-5 space-y-3">
                    @forelse($pendingCheckouts as $item)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm font-semibold text-slate-900">{{ $item['guest'] ?? 'Unknown Guest' }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ $item['booking_code'] ?? '—' }} • {{ ucfirst($item['status'] ?? '—') }}
                            </p>
                            <p class="mt-1 text-xs text-amber-600">
                                Balance: ₱{{ number_format((float) ($item['balance'] ?? 0), 2) }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                            No pending check-outs in this snapshot.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="xl:col-span-12 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900">Unsettled Accounts Snapshot</h2>
                <p class="mt-1 text-sm text-slate-500">Open balances recorded when this audit was completed.</p>

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
                            @forelse($unsettledAccounts as $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-900">{{ $item['guest'] ?? 'Unknown Guest' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $item['booking_code'] ?? '—' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ ucfirst(str_replace('_', ' ', $item['status'] ?? '—')) }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-amber-600">
                                        ₱{{ number_format((float) ($item['balance'] ?? 0), 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-500">
                                        No unsettled accounts in this snapshot.
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

    .print\:hidden,
    button,
    a {
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
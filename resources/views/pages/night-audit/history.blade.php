<x-layouts.layout>

<div class="min-h-screen bg-slate-100">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                Operations • Night Audit History
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Night Audit History
            </h1>
            <p class="mt-1 text-sm text-slate-500 sm:text-base">
                Review completed daily audit snapshots.
            </p>
        </div>

        <div class="overflow-hidden rounded-[30px] border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Audit Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Revenue</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Outstanding</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">In House</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Audited At</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($audits as $audit)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                    {{ $audit->audit_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-emerald-600 font-semibold">
                                    ₱{{ number_format($audit->daily_revenue, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-amber-600 font-semibold">
                                    ₱{{ number_format($audit->outstanding_balance, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $audit->in_house_count }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ optional($audit->audited_at)->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $audit->user->name ?? 'System' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('night-audit.show', $audit) }}"
                                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-slate-700">
                                        View Snapshot
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    No audit history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $audits->links() }}
            </div>
        </div>
    </div>
</div>
</x-layouts.layout>
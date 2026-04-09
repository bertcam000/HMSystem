<x-layouts.layout>
<div class="min-h-screen ">
    <div class="mx-auto w-full">

        <!-- Header -->
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    Billing • Invoices
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Invoices
                </h1>
                <p class="mt-1 text-sm text-slate-500 sm:text-base">
                    Review billing records, payment status, and invoice summaries for all bookings.
                </p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Invoices</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $totalInvoices }}</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12h6m-6 4h6M7.5 4.5h9A1.5 1.5 0 0 1 18 6v12a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 6 18V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">All booking invoices recorded in the system</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Paid</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">{{ $paidInvoices }}</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Invoices with fully settled balances</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Partial</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">{{ $partialInvoices }}</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Invoices with remaining balances</p>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Unpaid</p>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-rose-600">{{ $unpaidInvoices }}</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-slate-400">Invoices without any completed payment</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('invoices.index') }}" class="grid grid-cols-1 gap-4 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Search</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search guest, booking code, or status..."
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Booking Status</label>
                    <select
                        name="status"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                        <option value="">All Statuses</option>
                        <option value="reserved" @selected(request('status') === 'reserved')>Reserved</option>
                        <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmed</option>
                        <option value="checked_in" @selected(request('status') === 'checked_in')>Checked In</option>
                        <option value="checked_out" @selected(request('status') === 'checked_out')>Checked Out</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Payment Status</label>
                    <select
                        name="payment_status"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                        <option value="">All Payments</option>
                        <option value="paid" @selected(request('payment_status') === 'paid')>Paid</option>
                        <option value="partial" @selected(request('payment_status') === 'partial')>Partial</option>
                        <option value="unpaid" @selected(request('payment_status') === 'unpaid')>Unpaid</option>
                    </select>
                </div>

                <div class="lg:col-span-4 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a
                        href="{{ route('invoices.index') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Reset
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                    >
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-[30px] border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Guest</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Booking Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Room</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Stay</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Balance</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Payment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($bookings as $booking)
                            @php
                                $guest = $booking->guest;
                                $room = $booking->rooms->first();
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
                                    @if($room)
                                        Room {{ $room->room_number }}
                                        <div class="text-xs text-slate-400">{{ $room->roomType->name ?? 'Room Type' }}</div>
                                    @else
                                        <span class="text-slate-400">No room assigned</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <div>{{ $booking->check_in_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-slate-400">to {{ $booking->check_out_date->format('M d, Y') }}</div>
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    ₱{{ number_format($booking->total_price, 2) }}
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

                                <td class="px-6 py-4 text-right">
                                    <a
                                        href="{{ route('invoices.show', $booking) }}"
                                        class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-slate-700"
                                    >
                                        View Invoice
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 12h6m-6 4h6M7.5 4.5h9A1.5 1.5 0 0 1 18 6v12a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 6 18V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-sm font-semibold text-slate-900">No invoices found</h3>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Try adjusting your search or filter settings.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($bookings->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</x-layouts.layout>
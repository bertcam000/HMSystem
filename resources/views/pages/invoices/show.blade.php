<x-layouts.layout>

<div class="min-h-screen">
    <div class="mx-auto w-full">

        @php
            $guest = $booking->guest;
            $rooms = $booking->rooms;
            // $charges = $booking->charges;
            $payments = $booking->payments;

            $firstRoom = $rooms->first();
            $nights = \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date));

            $roomChargeSubtotal = (float) $booking->subtotal;
            $grandTotal = (float) $booking->total_price;
            $totalPayments = (float) $booking->paid_amount;
            $balanceDue = (float) $booking->balance;
        @endphp

        <!-- Top Action Bar -->
        <div class="mb-4 flex items-center justify-between print:hidden">
            <a href="{{ route('invoices.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                ← Back
            </a>

            <button onclick="window.print()"
                    class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
                Print Invoice
            </button>
        </div>

        <!-- Printable Invoice -->
        <div class="mx-auto invoice-sheet rounded-[20px] border px-5 max-w-sm border-slate-200 bg-white shadow-sm">
            <div class="px-8 py-8 sm:px-10">

                <!-- Header -->
                <div class="flex items-start justify-between gap-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.75 21h16.5M4.5 3h15m-14.25 0h13.5A1.5 1.5 0 0 1 20.25 4.5v16.5M3.75 4.5A1.5 1.5 0 0 1 5.25 3m-1.5 1.5V21m4.5-13.5h7.5m-7.5 4.5h7.5m-7.5 4.5h4.5" />
                            </svg>
                        </div>

                        <div>
                            <h1 class="text-lg font-bold tracking-tight text-slate-900">
                                HotelDesk
                            </h1>
                            <p class="text-xs text-slate-400">
                                Grand Imperial Hotel &amp; Suites
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <h2 class="text-2xl font-extrabold tracking-wide text-blue-700">
                            INVOICE
                        </h2>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-blue-600">
                            {{ $booking->booking_code }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            Issued: {{ now()->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 border-t border-slate-200"></div>

                <!-- Bill To / Stay Details -->
                <div class="mt-6 grid grid-cols-1 gap-8 sm:grid-cols-2">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                            Bill To
                        </p>
                        <p class="mt-3 text-sm font-bold text-slate-900">
                            {{ $guest->first_name }} {{ $guest->last_name }}
                        </p>
                        @if($guest->email)
                            <p class="mt-1 text-sm text-slate-500">{{ $guest->email }}</p>
                        @endif
                        @if($guest->phone)
                            <p class="text-sm text-slate-500">{{ $guest->phone }}</p>
                        @endif
                    </div>

                    <div class="sm:text-right">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                            Stay Details
                        </p>

                        <div class="mt-3 space-y-1 text-sm text-slate-600">
                            <p>
                                Room Type:
                                <span class="font-medium text-slate-900">
                                    {{ $firstRoom?->roomType?->name ?? '—' }}
                                </span>
                            </p>
                            <p>
                                Room Number:
                                <span class="font-medium text-slate-900">
                                    {{ $firstRoom?->room_number ?? '—' }}
                                </span>
                            </p>
                            <p>
                                Check-In:
                                <span class="font-medium text-slate-900">
                                    {{ $booking->check_in_date->format('Y-m-d') }}
                                </span>
                            </p>
                            <p>
                                Check-Out:
                                <span class="font-medium text-slate-900">
                                    {{ $booking->check_out_date->format('Y-m-d') }}
                                </span>
                            </p>
                            <p>
                                Duration:
                                <span class="font-medium text-slate-900">
                                    {{ $nights }} night{{ $nights !== 1 ? 's' : '' }}
                                </span>
                            </p>
                            <p>
                                Guests:
                                <span class="font-medium text-slate-900">
                                    {{ ($booking->adult ?? 0) }} adult(s), {{ ($booking->childen ?? 0) }} child(ren)
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="mt-8 overflow-hidden rounded-xl border border-slate-200">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Description
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500 w-20">
                                    Qty
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500 w-28">
                                    Rate
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500 w-28">
                                    Amount
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @foreach($rooms as $room)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-700">
                                        Room Charge — {{ $room->roomType->name ?? 'Room' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-slate-600">
                                        {{ $nights }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm text-slate-600">
                                        ₱{{ number_format((float) ($room->roomType->price ?? 0), 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-semibold text-slate-900">
                                        ₱{{ number_format((float) ($room->roomType->price ?? 0) * $nights, 2) }}
                                    </td>
                                </tr>
                            @endforeach

                            {{-- @foreach($charges as $charge)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-700">
                                        {{ ucwords(str_replace('_', ' ', $charge->type)) }}
                                        @if($charge->description)
                                            <span class="text-slate-400">— {{ $charge->description }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-slate-600">1</td>
                                    <td class="px-4 py-3 text-right text-sm text-slate-600">
                                        ₱{{ number_format($charge->amount, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-semibold text-slate-900">
                                        ₱{{ number_format($charge->amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach --}}

                            @if($booking->tax > 0)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-700">Tax</td>
                                    <td class="px-4 py-3 text-center text-sm text-slate-600">1</td>
                                    <td class="px-4 py-3 text-right text-sm text-slate-600">
                                        ₱{{ number_format($booking->tax, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-semibold text-slate-900">
                                        ₱{{ number_format($booking->tax, 2) }}
                                    </td>
                                </tr>
                            @endif

                            @if($booking->service_charge > 0)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-700">Service Charge</td>
                                    <td class="px-4 py-3 text-center text-sm text-slate-600">1</td>
                                    <td class="px-4 py-3 text-right text-sm text-slate-600">
                                        ₱{{ number_format($booking->service_charge, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-semibold text-slate-900">
                                        ₱{{ number_format($booking->service_charge, 2) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="mt-6 max-w-sm space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Room Charges Subtotal</span>
                        <span class="font-medium text-slate-900">₱{{ number_format($roomChargeSubtotal, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm font-semibold">
                        <span class="text-slate-900">Grand Total</span>
                        <span class="text-slate-900">₱{{ number_format($grandTotal, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-emerald-700">Total Payments Received</span>
                        <span class="font-semibold text-emerald-700">₱{{ number_format($totalPayments, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-200 pt-2 text-base font-bold">
                        <span class="text-emerald-700">Balance Due</span>
                        <span class="{{ $balanceDue > 0 ? 'text-amber-600' : 'text-emerald-700' }}">
                            ₱{{ number_format($balanceDue, 2) }}
                        </span>
                    </div>
                </div>

                <!-- Payment Records -->
                <div class="mt-8 border-t border-slate-200 pt-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                        Payment Records
                    </p>

                    <div class="mt-3 space-y-2">
                        @forelse($payments as $payment)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600">
                                    {{ ucfirst($payment->type) }} via {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                                <span class="font-semibold text-emerald-700">
                                    ₱{{ number_format($payment->amount, 2) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No payment records found.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="mt-10 border-t border-slate-200 pt-6 text-center">
                    <p class="text-xs text-slate-500">
                        Thank you for choosing Grand Imperial Hotel &amp; Suites.
                    </p>
                    <p class="text-xs text-slate-400">
                        We hope to see you again soon.
                    </p>

                    <p class="mt-4 text-[11px] tracking-wide text-slate-400">
                        This is a computer-generated invoice. No signature required.
                    </p>
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

        html, body {
            background: #ffffff !important;
        }

        body * {
            visibility: hidden;
        }

        .invoice-sheet,
        .invoice-sheet * {
            visibility: visible;
        }

        .invoice-sheet {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            overflow: visible !important;
        }

        .print\\:hidden {
            display: none !important;
        }
    }
</style>
    
</x-layouts.layout>
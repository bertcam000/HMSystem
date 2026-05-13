<x-layouts.layout>
    <div class="min-h-screen bg-slate-50 py-6 print:bg-white print:py-0">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8 print:max-w-full print:px-0">

            @php
                $guest = $booking->guest;
                $rooms = $booking->rooms;
                $payments = $booking->payments;

                $firstRoom = $rooms->first();
                $nights = \Carbon\Carbon::parse($booking->check_in_date)
                    ->diffInDays(\Carbon\Carbon::parse($booking->check_out_date));

                $roomChargeSubtotal = (float) $booking->subtotal;
                $grandTotal = (float) $booking->total_price;
                $totalPayments = (float) $booking->paid_amount;
                $balanceDue = (float) $booking->balance;
            @endphp

            <!-- Top Action Bar -->
            <div class="mb-6 flex items-center justify-between print:hidden">
                <a href="{{ route('invoices.index') }}"
                   class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <span>←</span>
                    Back to Invoices
                </a>

                <button onclick="window.print()"
                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700">
                    Print Invoice
                </button>
            </div>

            <!-- Invoice Sheet -->
            <div class="invoice-sheet overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm print:rounded-none print:border-0 print:shadow-none">

                <!-- Header Banner -->
                <div class="bg-slate-900 px-8 py-8 text-white sm:px-10 print:bg-white print:text-slate-900">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">

                        <div class="flex items-start gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/20 print:bg-slate-900 print:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3.75 21h16.5M4.5 3h15m-14.25 0h13.5A1.5 1.5 0 0 1 20.25 4.5v16.5M3.75 4.5A1.5 1.5 0 0 1 5.25 3m-1.5 1.5V21m4.5-13.5h7.5m-7.5 4.5h7.5m-7.5 4.5h4.5" />
                                </svg>
                            </div>

                            <div>
                                <h1 class="text-2xl font-black tracking-tight">
                                    HotelDesk
                                </h1>
                                <p class="mt-1 text-sm text-white/70 print:text-slate-500">
                                    LaNuevoHotel
                                </p>
                                <p class="mt-3 max-w-md text-xs leading-5 text-white/60 print:text-slate-500">
                                    Official billing statement for guest accommodation, room charges, payments, and remaining balance.
                                </p>
                            </div>
                        </div>

                        <div class="sm:text-right">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-white/60 print:text-slate-400">
                                Invoice
                            </p>
                            <h2 class="mt-2 text-3xl font-black tracking-tight">
                                {{ $booking->booking_code }}
                            </h2>
                            <p class="mt-2 text-sm text-white/70 print:text-slate-500">
                                Issued: {{ now()->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-8 sm:px-10">

                    <!-- Info Cards -->
                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

                        <!-- Bill To -->
                        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                Bill To
                            </p>

                            <h3 class="mt-3 text-lg font-bold text-slate-900">
                                {{ $guest->first_name }} {{ $guest->last_name }}
                            </h3>

                            <div class="mt-3 space-y-1 text-sm text-slate-600">
                                <p>{{ $guest->email ?: 'No email provided' }}</p>
                                <p>{{ $guest->phone ?: 'No phone provided' }}</p>
                            </div>
                        </div>

                        <!-- Stay Details -->
                        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                Stay Details
                            </p>

                            <div class="mt-3 space-y-2 text-sm">
                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Check-In</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ $booking->check_in_date->format('M d, Y') }}
                                    </span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Check-Out</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ $booking->check_out_date->format('M d, Y') }}
                                    </span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Duration</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ $nights }} night{{ $nights !== 1 ? 's' : '' }}
                                    </span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Guests</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ $booking->adult ?? 0 }} adult(s), {{ $booking->childen ?? 0 }} child(ren)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Room Details -->
                        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                Room Details
                            </p>

                            <div class="mt-3 space-y-2 text-sm">
                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Room Type</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ $firstRoom?->roomType?->name ?? '—' }}
                                    </span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Room No.</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ $firstRoom?->room_number ?? '—' }}
                                    </span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Status</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-500">Payment</span>
                                    <span class="font-semibold text-slate-900">
                                        {{ ucfirst(str_replace('_', ' ', $booking->payment_status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mt-8 overflow-hidden rounded-[24px] border border-slate-200">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-100">
                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                        Description
                                    </th>
                                    <th class="w-24 px-5 py-4 text-center text-xs font-bold uppercase tracking-wide text-slate-500">
                                        Qty
                                    </th>
                                    <th class="w-36 px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                                        Rate
                                    </th>
                                    <th class="w-36 px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                                        Amount
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach($rooms as $room)
                                    <tr>
                                        <td class="px-5 py-4">
                                            <p class="text-sm font-semibold text-slate-900">
                                                Room Charge
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $room->roomType->name ?? 'Room' }} • Room {{ $room->room_number ?? '—' }}
                                            </p>
                                        </td>

                                        <td class="px-5 py-4 text-center text-sm text-slate-600">
                                            {{ $nights }}
                                        </td>

                                        <td class="px-5 py-4 text-right text-sm text-slate-600">
                                            ₱{{ number_format((float) ($room->roomType->price ?? 0), 2) }}
                                        </td>

                                        <td class="px-5 py-4 text-right text-sm font-bold text-slate-900">
                                            ₱{{ number_format((float) ($room->roomType->price ?? 0) * $nights, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                @if($booking->tax > 0)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                            Tax
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm text-slate-600">1</td>
                                        <td class="px-5 py-4 text-right text-sm text-slate-600">
                                            ₱{{ number_format($booking->tax, 2) }}
                                        </td>
                                        <td class="px-5 py-4 text-right text-sm font-bold text-slate-900">
                                            ₱{{ number_format($booking->tax, 2) }}
                                        </td>
                                    </tr>
                                @endif

                                @if($booking->service_charge > 0)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                            Service Charge
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm text-slate-600">1</td>
                                        <td class="px-5 py-4 text-right text-sm text-slate-600">
                                            ₱{{ number_format($booking->service_charge, 2) }}
                                        </td>
                                        <td class="px-5 py-4 text-right text-sm font-bold text-slate-900">
                                            ₱{{ number_format($booking->service_charge, 2) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Section -->
                    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">

                        <!-- Payment Records -->
                        <div class="rounded-[24px] border border-slate-200 bg-white p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                Payment Records
                            </p>

                            <div class="mt-4 space-y-3">
                                @forelse($payments as $payment)
                                    <div class="flex items-center justify-between gap-4 rounded-2xl bg-emerald-50 px-4 py-3">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">
                                                {{ ucfirst(str_replace('_', ' ', $payment->type)) }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                via {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                            </p>
                                        </div>

                                        <span class="text-sm font-bold text-emerald-700">
                                            ₱{{ number_format($payment->amount, 2) }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="rounded-2xl bg-slate-50 px-4 py-4 text-sm text-slate-500">
                                        No payment records found.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Totals -->
                        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                Summary
                            </p>

                            <div class="mt-4 space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500">Room Charges Subtotal</span>
                                    <span class="font-semibold text-slate-900">
                                        ₱{{ number_format($roomChargeSubtotal, 2) }}
                                    </span>
                                </div>

                                @if($booking->tax > 0)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Tax</span>
                                        <span class="font-semibold text-slate-900">
                                            ₱{{ number_format($booking->tax, 2) }}
                                        </span>
                                    </div>
                                @endif

                                @if($booking->service_charge > 0)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Service Charge</span>
                                        <span class="font-semibold text-slate-900">
                                            ₱{{ number_format($booking->service_charge, 2) }}
                                        </span>
                                    </div>
                                @endif

                                <div class="border-t border-slate-200 pt-3">
                                    <div class="flex items-center justify-between text-base font-bold">
                                        <span class="text-slate-900">Grand Total</span>
                                        <span class="text-slate-900">
                                            ₱{{ number_format($grandTotal, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-emerald-700">Payments Received</span>
                                    <span class="font-bold text-emerald-700">
                                        ₱{{ number_format($totalPayments, 2) }}
                                    </span>
                                </div>

                                <div class="rounded-2xl {{ $balanceDue > 0 ? 'bg-amber-100' : 'bg-emerald-100' }} px-4 py-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-bold {{ $balanceDue > 0 ? 'text-amber-800' : 'text-emerald-800' }}">
                                            Balance Due
                                        </span>
                                        <span class="text-xl font-black {{ $balanceDue > 0 ? 'text-amber-800' : 'text-emerald-800' }}">
                                            ₱{{ number_format($balanceDue, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-10 border-t border-slate-200 pt-6 text-center">
                        <p class="text-sm font-semibold text-slate-700">
                            Thank you for choosing LaNuevoHotel.
                        </p>
                        <p class="mt-1 text-xs text-slate-400">
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
            margin: 6mm;
        }

        html,
        body {
            background: #fff !important;
            width: 210mm;
            height: 297mm;
            overflow: hidden !important;
            zoom: 92%;
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
            inset: 0;
            width: 100% !important;
            max-width: 100% !important;

            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;

            overflow: hidden !important;
            page-break-inside: avoid !important;

            transform: scale(0.96);
            transform-origin: top center;
        }

        table {
            page-break-inside: avoid !important;
        }

        tr,
        td,
        th {
            page-break-inside: avoid !important;
        }

        .print\:hidden {
            display: none !important;
        }

        /* Compact spacing for print */
        .invoice-sheet .px-8,
        .invoice-sheet .sm\:px-10 {
            padding-left: 18px !important;
            padding-right: 18px !important;
        }

        .invoice-sheet .py-8 {
            padding-top: 18px !important;
            padding-bottom: 18px !important;
        }

        .invoice-sheet .mt-10 {
            margin-top: 20px !important;
        }

        .invoice-sheet .mt-8 {
            margin-top: 16px !important;
        }

        .invoice-sheet .mt-6 {
            margin-top: 12px !important;
        }

        .invoice-sheet .gap-8 {
            gap: 14px !important;
        }

        .invoice-sheet .space-y-3 > * + * {
            margin-top: 8px !important;
        }

        .invoice-sheet .space-y-2 > * + * {
            margin-top: 5px !important;
        }

        /* Smaller fonts for print */
        .invoice-sheet h1 {
            font-size: 22px !important;
        }

        .invoice-sheet h2 {
            font-size: 24px !important;
        }

        .invoice-sheet p,
        .invoice-sheet span,
        .invoice-sheet td,
        .invoice-sheet th {
            font-size: 11px !important;
        }
    }
</style>
</x-layouts.layout>
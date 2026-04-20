@php
    $canAddPayment = $booking->balance > 0 && !in_array($booking->status, ['cancelled', 'checked_out']);
@endphp

<x-layouts.layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto w-full">

            <!-- Header -->
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-400">HMS Booking Management</p>
                    <h1 class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">
                        Booking #{{ $booking->booking_code }}
                    </h1>
                    <p class="mt-2 text-sm text-slate-500">
                        View reservation details, payment history, and stay information.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="/bookings"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-100">
                        Back
                    </a>

                    @if ($canAddPayment)
                        <button
                            type="button"
                            onclick="document.getElementById('paymentModal').classList.remove('hidden')"
                            class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                        >
                            Add Payment
                        </button>
                    @endif
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

                <!-- Left Content -->
                <div class="space-y-6 xl:col-span-8">

                    <!-- Booking Information -->
                    <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 px-6 py-5">
                            <h2 class="text-lg font-semibold text-slate-900">Booking Information</h2>
                            <p class="mt-1 text-sm text-slate-500">Reservation details and stay summary.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Guest Name</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ $booking->guest->first_name }} {{ $booking->guest->last_name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-500">Room Type</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ $booking->room->roomType->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-500">Room Number</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ $booking->room->room_number ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-500">Status</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-500">Check In</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-slate-500">Check Out</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Payment History</h2>
                                <p class="mt-1 text-sm text-slate-500">All payment transactions for this booking.</p>
                            </div>

                            @if ($canAddPayment)
                                <button
                                    type="button"
                                    onclick="document.getElementById('paymentModal').classList.remove('hidden')"
                                    class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                                >
                                    + Add Payment
                                </button>
                            @endif
                        </div>

                        <div class="p-6">
                            @forelse ($booking->payments as $payment)
                                <div class="mb-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 last:mb-0">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">
                                                ₱ {{ number_format($payment->amount, 2) }}
                                            </p>
                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'cash')) }}
                                            </p>
                                        </div>

                                        <div class="text-sm text-slate-500">
                                            {{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-200 p-6 text-center">
                                    <p class="text-sm text-slate-500">No payment records found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6 xl:col-span-4">

                    <!-- Payment Summary -->
                    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900">Payment Summary</h2>

                            @if ($booking->status === 'cancelled')
                                <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                    Cancelled
                                </span>
                            @elseif ($booking->balance > 0)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    Balance Due
                                </span>
                            @else
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Fully Paid
                                </span>
                            @endif
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Total Amount</span>
                                <span class="font-semibold text-slate-900">
                                    ₱ {{ number_format($booking->total_price, 2) }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Paid Amount</span>
                                <span class="font-semibold text-slate-900">
                                    ₱ {{ number_format($booking->paid_amount, 2) }}
                                </span>
                            </div>

                            <div class="border-t border-dashed border-slate-200 pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-base font-semibold text-slate-900">Remaining Balance</span>
                                    <span class="text-xl font-bold text-slate-900">
                                        ₱ {{ number_format($booking->balance, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Actions -->
                    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-900">Actions</h2>
                        <p class="mt-1 text-sm text-slate-500">Available actions for this booking.</p>

                        <div class="mt-5 grid grid-cols-1 gap-3">
                            {{-- @if ($booking->status === 'confirmed')
                                <button class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                    Check In
                                </button>

                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="w-full rounded-2xl border border-red-200 px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                        onclick="return confirm('Are you sure you want to cancel this booking?')"
                                    >
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif

                            @if ($booking->status === 'checked_in')
                                <button class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                    Check Out
                                </button>
                            @endif --}}


                            @if(in_array($booking->status, ['reserved', 'confirmed', 'pending']))
                                {{-- <a href="/booking/check-in/{{ $booking->id }}"
                                     class="text-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                    Confirm Check In
                                </a> --}}
                                <a href="/check-in/{{ $booking->id }}"
                                     class="text-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                    Confirm Check In
                                </a>

                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="w-full rounded-2xl border border-red-200 px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                        onclick="return confirm('Are you sure you want to cancel this booking?')"
                                    >
                                        Cancel Booking
                                    </button>
                                </form>

                            @elseif($booking->status === 'checked_in')
                                <a href="/check-out/{{ $booking->id }}"
                                class="text-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                                    Confirm Check Out
                                </a>
                            @endif
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($canAddPayment)
        <!-- Payment Modal -->
        <div id="paymentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <p class="text-sm text-slate-500">Booking Payment</p>
                        <h3 class="mt-1 text-2xl font-bold text-slate-900">Add Payment</h3>
                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('paymentModal').classList.add('hidden')"
                        class="rounded-full p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6">
                    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Amount</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">
                                ₱ {{ number_format($booking->total_price, 2) }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Paid Amount</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">
                                ₱ {{ number_format($booking->paid_amount, 2) }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-amber-500">Remaining Balance</p>
                            <p class="mt-2 text-lg font-bold text-amber-700">
                                ₱ {{ number_format($booking->balance, 2) }}
                            </p>
                        </div>
                    </div>

                    <livewire:booking.payment :booking="$booking->id" />
                </div>
            </div>
        </div>
    @endif
</x-layouts.layout>
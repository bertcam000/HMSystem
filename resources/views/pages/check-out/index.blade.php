<x-layouts.layout>
    <div class="min-h-screen">
        <div class="mx-auto w-full">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @php
                $rooms = $booking->rooms;
                $guestInitials = strtoupper(substr($guest->first_name ?? '', 0, 1) . substr($guest->last_name ?? '', 0, 1));
                $nights = \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date));
            @endphp

            <!-- Header -->
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-start gap-4">
                    <a
                        href="{{ url()->previous() }}"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </a>

                    <div>
                        <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-100">
                            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                            Front Desk • Check-Out
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Guest Check-Out
                        </h1>
                        <p class="mt-1 text-sm text-slate-500 sm:text-base">
                            Review stay details, confirm settlement, and complete the guest departure.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap sm:justify-end">
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Booking Code</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $booking->booking_code }}</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Check-In</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y h:i A') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Status</p>
                        <p class="mt-1 text-sm font-semibold text-emerald-600">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
                <!-- Main -->
                <div class="xl:col-span-8">
                    <div class="space-y-6">
                        <!-- Reservation Summary -->
                        <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-slate-900">Stay Summary</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Final review of the guest reservation before completing check-out.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Booking Code</label>
                                    <input type="text" value="{{ $booking->booking_code }}" readonly
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                                    <input type="text" value="{{ ucfirst(str_replace('_', ' ', $booking->status)) }}" readonly
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-emerald-600 outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Check-In Date</label>
                                    <input type="text" value="{{ $booking->check_in_date->format('M d, Y') }}" readonly
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Check-Out Date</label>
                                    <input type="text" value="{{ $booking->check_out_date->format('M d, Y') }}" readonly
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Number of Nights</label>
                                    <input type="text" value="{{ $nights }} {{ \Illuminate\Support\Str::plural('Night', $nights) }}" readonly
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Guests</label>
                                    <input type="text" value="{{ ($booking->adult ?? 0) . ' Adult(s), ' . ($booking->childen ?? 0) . ' Child(ren)' }}" readonly
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Booked Rooms -->
                        <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-slate-900">Booked Rooms</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    These rooms will be released and marked available after check-out.
                                </p>
                            </div>

                            <div class="space-y-3">
                                @forelse($rooms as $room)
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="flex items-center gap-4">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">
                                                    {{ $room->room_number }}
                                                </div>

                                                <div>
                                                    <p class="text-sm font-semibold text-slate-900">
                                                        Room {{ $room->room_number }}
                                                    </p>
                                                    <p class="text-xs text-slate-500">
                                                        {{ $room->roomType->name ?? 'Room Type' }} • Floor {{ $room->floor }}
                                                    </p>
                                                </div>
                                            </div>

                                            <span class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                                <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                                {{ $room->status }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center">
                                        <p class="text-sm font-medium text-slate-600">No booked rooms found.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Departure Confirmation -->
                        <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-slate-900">Departure Confirmation</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Make sure all charges are settled before completing the guest departure.
                                </p>
                            </div>

                            @if ((float) $booking->balance > 0)
                                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm font-medium text-red-700">
                                    This booking still has an unpaid balance of ₱{{ number_format($booking->balance, 2) }}.
                                    Please settle payment before check-out.
                                </div>
                            @else
                                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm font-medium text-emerald-700">
                                    All charges are fully paid. This booking is ready for check-out.
                                </div>
                            @endif

                            <form action="{{ route('hms.check-out.store', $booking) }}" method="POST" class="mt-6">
                                @csrf

                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        @disabled((float) $booking->balance > 0)
                                        class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Complete Check-Out
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="xl:col-span-4">
                    <div class="space-y-6">
                        <!-- Guest Summary -->
                        <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="mb-5 flex items-center justify-between">
                                <h3 class="text-lg font-bold text-slate-900">Guest Summary</h3>
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                    Main Guest
                                </span>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-900 text-lg font-bold text-white">
                                    {{ $guestInitials ?: 'GU' }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $guest->first_name }} {{ $guest->last_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $guest->email ?: 'No email provided' }}</p>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div class="flex items-start justify-between gap-4">
                                    <span class="text-sm text-slate-500">Phone</span>
                                    <span class="text-sm font-semibold text-slate-900">{{ $guest->phone ?: '—' }}</span>
                                </div>

                                <div class="flex items-start justify-between gap-4">
                                    <span class="text-sm text-slate-500">ID Type</span>
                                    <span class="text-sm font-semibold text-slate-900">{{ $guest->id_type }}</span>
                                </div>

                                <div class="flex items-start justify-between gap-4">
                                    <span class="text-sm text-slate-500">ID Number</span>
                                    <span class="text-sm font-semibold text-slate-900">{{ $guest->id_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Summary -->
                        <div class="rounded-[30px] border border-slate-200 bg-slate-900 p-6 text-white shadow-sm">
                            <div class="mb-5 flex items-center justify-between">
                                <h3 class="text-lg font-bold">Final Billing</h3>
                                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white">
                                    Departure
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between text-sm text-slate-300">
                                    <span>Subtotal</span>
                                    <span class="font-medium text-white">₱{{ number_format($booking->subtotal, 2) }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm text-slate-300">
                                    <span>Tax</span>
                                    <span class="font-medium text-white">₱{{ number_format($booking->tax, 2) }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm text-slate-300">
                                    <span>Service Charge</span>
                                    <span class="font-medium text-white">₱{{ number_format($booking->service_charge, 2) }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm text-slate-300">
                                    <span>Paid</span>
                                    <span class="font-medium text-emerald-300">₱{{ number_format($booking->paid_amount, 2) }}</span>
                                </div>

                                <div class="border-t border-white/10 pt-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-slate-300">Remaining Balance</span>
                                        <span class="text-2xl font-bold tracking-tight {{ (float) $booking->balance > 0 ? 'text-amber-300' : 'text-white' }}">
                                            ₱{{ number_format($booking->balance, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Front Desk Notes -->
                        <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="mb-4 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 6h.008v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">Front Desk Notes</h3>
                            </div>

                            <div class="space-y-3 text-sm text-slate-600">
                                <p>• Confirm room key/card return before completing check-out.</p>
                                <p>• Verify all unpaid balances are settled.</p>
                                <p>• Inspect room status if needed before releasing it.</p>
                                <p>• Mark room as available after successful departure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
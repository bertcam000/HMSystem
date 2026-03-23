<x-layouts.layout>

    @if (session('success'))
        <x-notification :message="session('success')" type="success" />
    @endif

    <div class="min-h-screen bg-white border bordder-gray-400/50 p-4 md:p-6">
        <div class="mx-auto max-w-7xl space-y-6">

            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Booking Details</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-900">{{ $booking->booking_code }}</h1>
                    <p class="mt-2 text-sm text-slate-500">Review booking information, room stay details, and payment records.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <span class="{{ $booking->status === 'reserved' ? 'text-amber-700 bg-amber-100' : 'bg-green-100 text-green-700'}} inline-flex items-center rounded-full  px-4 py-2 text-sm font-semibold ">
                        {{ $booking->status }}
                    </span>
                    <span class="{{ $booking->payment_status === 'unpaid' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} inline-flex items-center rounded-full  px-4 py-2 text-sm font-semibold ">
                        {{ $booking->payment_status }}
                    </span>
                    @if ($booking->balance !== 0)
                        <button type="button" onclick="document.getElementById('paymentModal').classList.remove('hidden')" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Add Payment</button>
                    @endif
                </div>
            </div>

            <!-- Top Grid -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                <!-- Left Content -->
                <div class="xl:col-span-2 space-y-6">

                    <!-- Guest + Booking Info -->
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="mb-5 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Guest Information</p>
                                    <h2 class="mt-1 text-xl font-bold text-slate-900">{{ $booking->guest->first_name . ' ' . $booking->guest->last_name }}</h2>
                                </div>
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-lg font-bold text-slate-700">
                                    {{ $firstLetter = strtoupper(substr($booking->guest->first_name, 0, 1)); }}
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                    <span class="text-sm text-slate-500">Email</span>
                                    <span class="text-sm font-medium text-slate-800">{{ $booking->guest->email }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                    <span class="text-sm text-slate-500">Phone</span>
                                    <span class="text-sm font-medium text-slate-800">{{ $booking->guest->phone }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-sm text-slate-500">Guest Type</span>
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ $booking->source }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="mb-5">
                                <p class="text-sm font-medium text-slate-500">Booking Information</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-900">Reservation Summary</h2>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                    <span class="text-sm text-slate-500">Booking Code</span>
                                    <span class="text-sm font-medium text-slate-800">{{ $booking->booking_code }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                    <span class="text-sm text-slate-500">Source</span>
                                    <span class="text-sm font-medium text-slate-800">{{ $booking->source }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                    <span class="text-sm text-slate-500">Created At</span>
                                    <span class="text-sm font-medium text-slate-800">{{ $booking->created_at->format('F d, Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-sm text-slate-500">Request</span>
                                    <span class="text-sm font-medium text-slate-800">{{ $booking->guest->notes }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stay Details -->
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Stay Details</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-900">Room & Schedule</h2>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                {{ $booking->status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Check In</p>
                                <p class="mt-2 text-base font-semibold text-slate-800">{{ $booking->check_in_date->format('F d, Y') }}</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Check Out</p>
                                <p class="mt-2 text-base font-semibold text-slate-800">{{ $booking->check_out_date->format('F d, Y') }}</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nights</p>
                                <p class="mt-2 text-base font-semibold text-slate-800">{{ $nights }}</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Guests</p>
                                <p class="mt-2 text-base font-semibold text-slate-800">{{ $booking->adult }} Adults, {{ $booking->childen }} Child</p>
                            </div>
                        </div>

                        <!-- Room Cards -->
                        <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
                            @foreach ($booking->rooms as $room)
                                
                            
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-lg font-bold text-slate-900">Room {{ $room->room_number }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $room->roomType->name }}</p>
                                        </div>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                            ₱{{ $room->roomType->price }} / night
                                        </span>
                                    </div>
                                    <p class="mt-4 text-sm text-slate-600">
                                        @foreach ($room->roomType->features as $features)
                                            {{ $features->name . ' / '}}
                                        @endforeach
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Payment Records</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-900">Payment History</h2>
                            </div>
                            @if ($booking->balance !== 0)
                            <button
                                type="button"
                                onclick="document.getElementById('paymentModal').classList.remove('hidden')"
                                class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                            >
                                + Add Payment
                            </button>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200 text-left">
                                        <th class="px-3 py-3 font-semibold text-slate-500">Date</th>
                                        <th class="px-3 py-3 font-semibold text-slate-500">Type</th>
                                        <th class="px-3 py-3 font-semibold text-slate-500">Method</th>
                                        <th class="px-3 py-3 font-semibold text-slate-500">Reference</th>
                                        <th class="px-3 py-3 font-semibold text-slate-500">Amount</th>
                                        <th class="px-3 py-3 font-semibold text-slate-500">Encoded By</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($booking->payments as $payment)
                                        
                                        <tr class="border-b border-slate-100">
                                            <td class="px-3 py-4 text-slate-700">{{ $payment->payment_date }}</td>
                                            <td class="px-3 py-4">
                                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ $payment->type }}</span>
                                            </td>
                                            <td class="px-3 py-4 text-slate-700">{{ $payment->payment_method }}</td>
                                            <td class="px-3 py-4 text-slate-500">—</td>
                                            <td class="px-3 py-4 font-semibold text-slate-900">{{ $payment->amount }}</td>
                                            <td class="px-3 py-4 text-slate-700">Admin</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6" x-data="{checkIn: false}">

                    <!-- Payment Summary -->
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Payment Summary</p>
                                <h2 class="mt-1 text-2xl font-bold text-slate-900">Overview</h2>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5m-18 0A2.25 2.25 0 0 0 1.5 10.5v7.125A2.25 2.25 0 0 0 3.75 19.875h16.5A2.25 2.25 0 0 0 22.5 17.625V10.5a2.25 2.25 0 0 0-2.25-2.25m-16.5 0V6.375A2.25 2.25 0 0 1 6 4.125h12a2.25 2.25 0 0 1 2.25 2.25V8.25" />
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach ($booking->rooms as $room)
                                <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Room {{ $room->room_number }}</span>
                                        <span class="font-medium text-slate-800">₱ {{ $room->roomType->price }}</span>
                                </div>
                            @endforeach

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Service Charge</span>
                                <span class="font-medium text-slate-800">₱ {{ $booking->service_charge }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Tax</span>
                                <span class="font-medium text-slate-800">₱ {{ $booking->tax }}</span>
                            </div>

                            {{-- <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Discount</span>
                                <span class="font-medium text-emerald-600">- ₱1,000.00</span>
                            </div> --}}
                        </div>

                        <div class="my-6 border-t border-slate-200"></div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Total Amount</p>
                                <p class="mt-1 text-3xl font-bold tracking-tight text-slate-900">₱ {{ $booking->total_price }}</p>
                            </div>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Balance Due
                            </span>
                        </div>

                        <div class="mt-6 rounded-2xl bg-slate-50 border border-slate-200 p-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Amount Paid</span>
                                <span class="font-semibold text-slate-800">₱ {{ $booking->paid_amount }}</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span class="text-slate-500">Remaining Balance</span>
                                <span class="font-semibold text-amber-600">₱ {{ $booking->balance }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <p class="text-sm font-medium text-slate-500">Quick Actions</p>
                            <h2 class="mt-1 text-xl font-bold text-slate-900">Manage Booking</h2>

                            <div class="mt-5 space-y-3">
                                @if ($booking->status === 'confirmed')
                                    <button @click="checkIn = true" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                                        <p>Check In Guest </p>
                                    </button>
                                    @elseif ($booking->status === 'checked_in')
                                        <button @click="checkIn = true" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                                            <p>Check Out Guest </p>
                                        </button>
                                    @else

                                    @endif
                                
                                

                                {{-- <button class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                    Edit Booking
                                </button> --}}

                                @if ($booking->status === 'reserved')
                                    <button class="w-full rounded-2xl border border-red-200 px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                                        Cancel Booking
                                    </button>
                                @endif
                            </div>
                        </div>

                    {{-- MODAl --}}
                    <div x-show="checkIn" x-cloak class="px-2 md:px-0 transition-all duration-300 flex h-screen w-full bg-black/20 fixed -top-7 left-0 z-50  justify-center items-center">
                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                            <div class="w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                                <!-- Header -->
                                <div class="border-b border-slate-200 px-6 py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                    <p class="text-sm font-medium text-emerald-600">Booking Check-In</p>
                                    <h2 class="mt-1 text-2xl font-bold text-slate-900">Confirm Guest Check-In</h2>
                                    <p class="mt-2 text-sm text-slate-500">Review the booking details before marking this guest as checked in.</p>
                                    </div>

                                    <button @click="checkIn = false" class="rounded-full p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    </button>
                                </div>
                                </div>

                                <!-- Body -->
                                <div class="space-y-6 px-6 py-6">
                                <!-- Top Status -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700"> Confirmed Booking </span>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'text-amber-700 bg-amber-100' }}"> {{ $booking->payment_status }} Payment </span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700"> {{ $booking->booking_code }} </span>
                                </div>

                                <!-- Main Details -->
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-slate-200 p-4">
                                    <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Guest Name</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $booking->guest->first_name . ' ' . $booking->guest->last_name }}</p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-200 p-4">
                                    <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Nights</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $nights }} Nights</p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-200 p-4">
                                    <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Check-In Date</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $booking->check_in_date->format('F d, Y') }}</p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-200 p-4">
                                    <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Check-Out Date</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $booking->check_out_date->format('F d, Y') }}</p>
                                    </div>

                                    

                                    
                                </div>

                                <!-- Payment Summary -->
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="mb-4 flex items-center justify-between">
                                    <p class="text-sm font-semibold text-slate-800">Payment Summary</p>
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700"> Balance Due </span>
                                    </div>

                                    <div class="space-y-3">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Total Amount</span>
                                        <span class="font-semibold text-slate-900">₱{{ $booking->total_price }}</span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Amount Paid</span>
                                        <span class="font-semibold text-slate-900">₱{{ $booking->paid_amount }}</span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Remaining Balance</span>
                                        <span class="font-semibold text-amber-600">₱{{ $booking->balance }}</span>
                                    </div>
                                    </div>
                                </div>

                                
                                </div>

                                <!-- Footer -->
                                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-end">
                                <button @click="checkIn = false" type="button" class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Cancel</button>

                                @if($booking->status !== 'checked_in')
                                    <a href="/booking/check-in/{{ $booking->id }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Confirm Check In</a>
                                @else
                                    <a href="/booking/check-out/{{ $booking->id }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Confirm Check Out</a>
                                @endif
                                </div>
                            </div>
                            </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Add Payment Modal -->
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
                    <!-- Booking Balance Preview -->
                    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Amount</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">₱ {{ $booking->total_price }}</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Paid Amount</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">₱ {{ $booking->paid_amount }}</p>
                        </div>

                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-amber-500">Remaining Balance</p>
                            <p class="mt-2 text-lg font-bold text-amber-700">₱ {{ $booking->balance }}</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <livewire:booking.payment :booking="$booking->id"/>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
<x-layouts.layout>



<div
    x-data="{ currentStep: {{ $errors->any() ? 4 : 1 }}, }"
    class="min-h-screen">
    <div class=" w-full ">
        <!-- Header -->
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <a
                    href="#"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </a>

                <div>
                    <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Front Desk • Check-In
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Guest Check-In
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 sm:text-base">
                        Review reservation details, verify guest information, assign room, and complete arrival.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap sm:justify-end">
                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Booking Code</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $booking->booking_code }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Arrival Date</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ now()->format('M d, Y') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Status</p>
                    <p class="mt-1 text-sm font-semibold text-amber-600">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</p>
                </div>
            </div>
        </div>

        <!-- Stepper -->
        <div class="mb-8 rounded-[30px] border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
            <div class="grid grid-cols-1 gap-3 lg:grid-cols-4">
                <!-- Step 1 -->
                <button
                    type="button"
                    @click="currentStep = 1"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-left transition"
                    :class="{
                        'bg-green-600 text-white shadow-sm': currentStep > 1,
                        'bg-blue-600 text-white shadow-sm': currentStep === 1,
                        'bg-slate-50 text-slate-500 hover:bg-slate-100': currentStep < 1
                    }"
                >
                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold"
                        :class="currentStep >= 1 ? 'bg-white/20 text-white' : 'bg-white text-slate-500 ring-1 ring-slate-200'"
                    >
                        <template x-if="currentStep > 1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="currentStep <= 1">
                            <span>1</span>
                        </template>
                    </span>

                    <div>
                        <p class="text-sm font-semibold">Reservation</p>
                        <p class="text-xs" :class="currentStep >= 1 ? 'text-white/80' : 'text-slate-400'">Booking overview</p>
                    </div>
                </button>

                <!-- Step 2 -->
                <button
                    type="button"
                    @click="currentStep = 2"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-left transition"
                    :class="{
                        'bg-green-600 text-white shadow-sm': currentStep > 2,
                        'bg-blue-600 text-white shadow-sm': currentStep === 2,
                        'bg-slate-50 text-slate-500 hover:bg-slate-100': currentStep < 2
                    }"
                >
                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold"
                        :class="currentStep >= 2 ? 'bg-white/20 text-white' : 'bg-white text-slate-500 ring-1 ring-slate-200'"
                    >
                        <template x-if="currentStep > 2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="currentStep <= 2">
                            <span>2</span>
                        </template>
                    </span>

                    <div>
                        <p class="text-sm font-semibold">Guest Details</p>
                        <p class="text-xs" :class="currentStep >= 2 ? 'text-white/80' : 'text-slate-400'">Verify information</p>
                    </div>
                </button>

                <!-- Step 3 -->
                <button
                    type="button"
                    @click="currentStep = 3"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-left transition"
                    :class="{
                        'bg-green-600 text-white shadow-sm': currentStep > 3,
                        'bg-blue-600 text-white shadow-sm': currentStep === 3,
                        'bg-slate-50 text-slate-500 hover:bg-slate-100': currentStep < 3
                    }"
                >
                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold"
                        :class="currentStep >= 3 ? 'bg-white/20 text-white' : 'bg-white text-slate-500 ring-1 ring-slate-200'"
                    >
                        <template x-if="currentStep > 3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="currentStep <= 3">
                            <span>3</span>
                        </template>
                    </span>

                    <div>
                        <p class="text-sm font-semibold">Room Assignment</p>
                        <p class="text-xs" :class="currentStep >= 3 ? 'text-white/80' : 'text-slate-400'">Allocate room</p>
                    </div>
                </button>

                <!-- Step 4 -->
                <button
                    type="button"
                    @click="currentStep = 4"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-left transition"
                    :class="{
                        'bg-green-600 text-white shadow-sm': currentStep > 4,
                        'bg-blue-600 text-white shadow-sm': currentStep === 4,
                        'bg-slate-50 text-slate-500 hover:bg-slate-100': currentStep < 4
                    }"
                >
                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold"
                        :class="currentStep >= 4 ? 'bg-white/20 text-white' : 'bg-white text-slate-500 ring-1 ring-slate-200'"
                    >
                        <template x-if="currentStep > 4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="currentStep <= 4">
                            <span>4</span>
                        </template>
                    </span>

                    <div>
                        <p class="text-sm font-semibold">Payment</p>
                        <p class="text-xs" :class="currentStep >= 4 ? 'text-white/80' : 'text-slate-400'">Settle charges</p>
                    </div>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
            <!-- Main -->
            <div class="xl:col-span-8">
                <div class="rounded-[30px] border border-slate-200 bg-white shadow-sm">
                    <!-- Reservation -->
                    <section x-show="currentStep === 1" x-transition.opacity.duration.200ms class="p-6 sm:p-8">
                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-slate-900">Reservation Information</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Review the booking details before proceeding with guest verification.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Booking Code</label>
                                <input type="text" value="RES-00021" readonly
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Reservation Status</label>
                                <input type="text" value="{{ $booking->status }}" readonly
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-amber-600 outline-none">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Check-In Date</label>
                                <input type="text" value="{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}" readonly
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Check-Out Date</label>
                                <input type="text" value="{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}" readonly
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Room Type</label>
                                <input type="text" value="{{ $booking->rooms->first()->roomType->name }}" readonly
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Guests</label>
                                <input type="text" value="{{ $booking->adult }} Adults, {{ $booking->children ?? 0 }} Children" readonly
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button
                                type="button"
                                @click="currentStep = 2"
                                class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                            >
                                Continue
                            </button>
                        </div>
                    </section>

                    <!-- Guest Details -->
                    <section x-show="currentStep === 2" x-transition.opacity.duration.200ms x-cloak class="p-6 sm:p-8">
                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-slate-900">Guest Details</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Verify personal information and identification before issuing room access.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-slate-700">Full Name</label>
                                <input type="text" value="{{ $booking->guest->first_name . ' ' . $booking->guest->last_name }}" readonly
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                                <input type="email" value="{{ $booking->guest->email }}" readonly
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Phone Number</label>
                                <input type="text" value="{{ $booking->guest->phone }}" readonly
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">ID Type</label>
                                <select
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                    <option>{{ $booking->guest->id_type }}</option>
                                    <option>Driver's License</option>
                                    <option>National ID</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">ID Number</label>
                                <input type="text" value="P1234567"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-between">
                            <button
                                type="button"
                                @click="currentStep = 1"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Back
                            </button>

                            <button
                                type="button"
                                @click="currentStep = 3"
                                class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                            >
                                Continue
                            </button>
                        </div>
                    </section>

                    <!-- Room Assignment -->
                    <section x-show="currentStep === 3" x-transition.opacity.duration.200ms x-cloak class="p-6 sm:p-8">
                        <div class="mb-6">
                            <h2 class="text-xl font-bold text-slate-900">Room Assignment</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Confirm the assigned room and ensure the room is ready for occupancy.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 ">
                            {{-- <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Assigned Room</label>
                                <input value="asdasd
                                @foreach ($booking->rooms as $room)
                                    {{ $room->room_number }} 
                                    
                                @endforeach
                                 " class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"></input>
                            </div> --}}

                            <div class="grid grid-cols-1 gap-5">
                                <div>
                                    <label class="mb-3 block text-sm font-medium text-slate-700">
                                        Booked Rooms
                                    </label>

                                    <div class="rounded-[28px] border border-slate-200 bg-white p-4 shadow-sm">
                                        @forelse($booking->rooms as $room)
                                            <div class="mb-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 last:mb-0">
                                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                                    <div class="flex items-center gap-4">
                                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-sm font-bold text-blue-700">
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

                                                    <div>
                                                        @php
                                                            $status = strtolower($room->status);
                                                        @endphp

                                                        @if($status === 'available')
                                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                                Clean and Ready
                                                            </span>
                                                        @elseif($status === 'occupied')
                                                            <span class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                                                <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                                                Occupied
                                                            </span>
                                                        @elseif($status === 'maintenance')
                                                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                                                Maintenance
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                                                {{ $room->status }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center">
                                                <p class="text-sm font-medium text-slate-600">No booked rooms assigned yet</p>
                                                <p class="mt-1 text-xs text-slate-400">Assign a room first before completing check-in.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 rounded-[28px] border border-blue-100 bg-blue-50 p-5">
                            <p class="text-sm font-semibold text-blue-900">Room Readiness Note</p>
                            <p class="mt-1 text-sm text-blue-700">
                                Room has been inspected by housekeeping and is ready for guest occupancy.
                            </p>
                        </div>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-between">
                            <button
                                type="button"
                                @click="currentStep = 2"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Back
                            </button>

                            <button
                                type="button"
                                @click="currentStep = 4"
                                class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                            >
                                Continue
                            </button>
                        </div>
                    </section>

                    <!-- Payment -->
                    <section x-show="currentStep === 4" x-transition.opacity.duration.200ms x-cloak class="p-6 sm:p-8">
                        <form action="/booking/{{ $booking->id }}/payment" method="POST">
                            @csrf
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-slate-900">Payment & Completion</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Review charges, record payment, and complete the guest check-in.
                                </p>
                            </div>

                            @if ($booking->balance > 0)
                                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Payment Method</label>
                                        <select
                                            name="payment_method"
                                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                            <option value="cash">Cash</option>
                                            <option value="gcash">GCash</option>
                                            <option value="card">Card</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Amount Received</label>
                                        <input type="number" placeholder="0.00" name="amount" step="0.01"
                                            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                            @error('amount') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <div>
                                            <label class="mb-2 block text-sm font-medium text-slate-700">Payment Type</label>
                                            <select
                                                name="type"
                                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-slate-400"
                                            >
                                                <option value="deposit">Deposit</option>
                                                <option value="additional">Additional</option>
                                                <option value="full_payment">Full Payment</option>
                                                <option value="remaining_balance">Remaining Balance</option>
                                            </select>
                                            @error('type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Reference Number</label>
                                        <input type="number" placeholder="0.00" name="reference_number"
                                            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                    </div>

                                    <div class="col-span-2">
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Notes</label>
                                        <textarea
                                            name="notes"
                                            rows="4"
                                            placeholder="Add payment notes..."
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-slate-400"
                                        ></textarea>
                                        @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    
                                </div>
                                @else
                                    <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700">
                                        This booking is already fully paid. Ready for check-in.
                                    </div>
                            @endif

                            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="rounded-[28px] border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Total Charge</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900">₱ {{ number_format($booking->total_price, 2) }}</p>
                                </div>

                                <div class="rounded-[28px] border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Deposit Paid</p>
                                    <p class="mt-2 text-lg font-bold text-emerald-600">₱ {{ number_format($booking->paid_amount, 2) }}</p>
                                </div>

                                <div class="rounded-[28px] border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Balance Due</p>
                                    <p class="mt-2 text-lg font-bold text-amber-600">₱ {{ number_format($booking->balance, 2) }}</p>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-between">
                                <button
                                    type="button"
                                    @click="currentStep = 3"
                                    class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                >
                                    Back
                                </button>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                                >
                                    Complete Check-In
                                </button>
                            </div>
                        </form>
                    </section>
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
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500 text-lg font-bold text-white">
                                {{ strtoupper(substr($booking->guest->first_name, 0, 1) . substr($booking->guest->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $booking->guest->first_name . ' ' . $booking->guest->last_name }}</p>
                                <p class="text-sm text-slate-500">{{ $booking->guest->email }}</p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <span class="text-sm text-slate-500">Phone</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $booking->guest->phone }}</span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-sm text-slate-500">ID Type</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $booking->guest->id_type }}</span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-sm text-slate-500">ID Number</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $booking->guest->id_number }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stay Summary -->
                    <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-5 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-900">Stay Summary</h3>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                2 Nights
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Arrival</span>
                                <span class="font-semibold text-slate-900">{{ now()->format('M d, Y') }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Departure</span>
                                <span class="font-semibold text-slate-900">Apr 11, 2026</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Room Type</span>
                                <span class="font-semibold text-slate-900">Deluxe King</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Assigned Room</span>
                                <span class="font-semibold text-slate-900">Room 203</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Guests</span>
                                <span class="font-semibold text-slate-900">2 Adults</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="rounded-[30px] border border-slate-200 bg-slate-900 p-6 text-white shadow-sm">
                        <div class="mb-5 flex items-center justify-between">
                            <h3 class="text-lg font-bold">Payment Summary</h3>
                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white">
                                Due Today
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-sm text-slate-300">
                                <span>Room Charge</span>
                                <span class="font-medium text-white">₱ {{ number_format($booking->total_price, 2) }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm text-slate-300">
                                <span>Taxes & Fees</span>
                                <span class="font-medium text-white">₱ {{ number_format($booking->taxes_and_fees, 2) }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm text-slate-300">
                                <span>Deposit</span>
                                <span class="font-medium text-emerald-300">- ₱ {{ number_format($booking->paid_amount, 2) }}</span>
                            </div>

                            <div class="border-t border-white/10 pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-300">Balance Due</span>
                                    <span class="text-2xl font-bold tracking-tight text-white">₱ {{ number_format($booking->balance, 2) }}</span>
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
                            <p>• Verify guest ID before providing room access.</p>
                            <p>• Reconfirm number of guests and booking dates.</p>
                            <p>• Ensure the assigned room is clean and ready.</p>
                            <p>• Inform the guest about breakfast and checkout time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
</x-layouts.layout>
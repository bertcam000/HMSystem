<x-layouts.layout>
    <div class="min-h-screen">
        <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    RFID Check-out
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Scan the guest RFID card to automatically find the active checked-in booking.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('rfid.check-out.search') }}" class="space-y-4">

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            RFID UID
                        </label>

                        <input
                            id="rfid_uid"
                            type="text"
                            name="rfid_uid"
                            value=""
                            autofocus
                            autocomplete="off"
                            placeholder="Tap / scan RFID card..."
                            class="w-full rounded-2xl border-slate-200 text-sm">
                    </div>

                    <div class="flex justify-end">
                        <button class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                            Search Guest
                        </button>
                    </div>
                </form>
            </div>

            @if ($booking)
                @php
                    $balance = round((float) ($booking->total_price ?? 0) - (float) ($booking->paid_amount ?? 0), 2);
                @endphp

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6 flex flex-col gap-4 border-b border-slate-100 pb-6 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">
                                Active Booking Found
                            </p>

                            <h2 class="mt-1 text-xl font-bold text-slate-900">
                                {{ $booking->booking_code ?? 'BOOKING-' . $booking->id }}
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                RFID: {{ $booking->rfidCard->uid ?? $rfidUid }}
                            </p>
                        </div>

                        <span class="w-fit rounded-full bg-emerald-100 px-4 py-1.5 text-xs font-bold text-emerald-700 ring-1 ring-emerald-200">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                Guest
                            </p>

                            <p class="mt-2 text-lg font-bold text-slate-900">
                                {{ $booking->guest->first_name ?? '' }}
                                {{ $booking->guest->last_name ?? '' }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $booking->guest->email ?? 'No email' }}
                            </p>

                            <p class="text-sm text-slate-500">
                                {{ $booking->guest->phone ?? 'No phone' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                Stay Dates
                            </p>

                            <p class="mt-2 text-sm font-semibold text-slate-900">
                                Check-in:
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                Check-out:
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                            </p>

                            @if ($booking->checked_in_at)
                                <p class="mt-2 text-xs text-slate-500">
                                    Actual checked-in:
                                    {{ $booking->checked_in_at->format('M d, Y h:i A') }}
                                </p>
                            @endif
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                Rooms
                            </p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                @forelse ($booking->rooms as $room)
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                                        Room {{ $room->room_number }}
                                    </span>
                                @empty
                                    <span class="text-sm text-slate-400">No room assigned</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                Payment
                            </p>

                            <div class="mt-3 space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Total</span>
                                    <span class="font-semibold text-slate-900">
                                        ₱{{ number_format($booking->total_price ?? 0, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-slate-500">Paid</span>
                                    <span class="font-semibold text-slate-900">
                                        ₱{{ number_format($booking->paid_amount ?? 0, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between border-t border-slate-200 pt-2">
                                    <span class="font-semibold text-slate-700">Balance</span>

                                    <span class="font-bold {{ $balance > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                        ₱{{ number_format($balance, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('bookings.folio', $booking) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">
                            Open Folio / Add Charges
                        </a>

                        @if ($balance > 0)
                            <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm font-medium text-amber-700">
                                Guest still has a remaining balance. Settle payment first before checkout.
                            </div>
                        @else
                            <form
                                method="POST"
                                action="{{ route('rfid.check-out.checkout', $booking) }}"
                                onsubmit="return confirm('Confirm check-out for this guest?')">
                                @csrf

                                <button class="w-full rounded-2xl bg-slate-900 px-5 py-3 text-sm font-bold text-white hover:bg-slate-700 sm:w-auto">
                                    Confirm Check-out
                                </button>
                            </form>
                        @endif
                    </div>
                    
                </div>
            @endif
        </div>
    </div>

    <script>
    const rfidInput = document.getElementById('rfid_uid');

    if (rfidInput) {
        rfidInput.focus();

        rfidInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();

                if (this.value.trim() !== '') {
                    this.form.submit();
                }
            }
        });
    }
</script>
    
</x-layouts.layout>
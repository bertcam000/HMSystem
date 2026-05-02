<x-layouts.layout>
    <div class="min-h-screen">
        <div class="">

            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        RFID Check-in
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Scan an available RFID card and assign it to a confirmed guest booking.
                    </p>
                </div>
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

            <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <form method="GET" class="flex flex-col gap-3 md:flex-row">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search booking code, guest name, email, or phone..."
                        class="w-full rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">

                    <div class="flex gap-2">
                        <button class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                            Search
                        </button>

                        <a href="{{ route('rfid.check-in.index') }}"
                           class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="overflow-hidden rounded-2xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Booking
                                </th>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Guest
                                </th>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Room
                                </th>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Dates
                                </th>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>
                                <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($bookings as $booking)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-900">
                                            {{ $booking->booking_code ?? 'BOOKING-' . $booking->id }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            Created {{ $booking->created_at->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-900">
                                            {{ $booking->guest->first_name ?? '' }}
                                            {{ $booking->guest->last_name ?? '' }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ $booking->guest->email ?? 'No email' }}
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        @if ($booking->rooms->count())
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($booking->rooms as $room)
                                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                                        Room {{ $room->room_number }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-slate-400">No room assigned</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        <div>
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            to {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700 ring-1 ring-blue-200">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <button
                                            onclick="openCheckInModal(
                                                '{{ $booking->id }}',
                                                '{{ $booking->booking_code ?? 'BOOKING-' . $booking->id }}',
                                                '{{ trim(($booking->guest->first_name ?? '') . ' ' . ($booking->guest->last_name ?? '')) }}'
                                            )"
                                            class="rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-700">
                                            Scan RFID
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-12 text-center">
                                        <div class="text-sm font-semibold text-slate-700">
                                            No confirmed bookings found
                                        </div>
                                        <div class="mt-1 text-sm text-slate-400">
                                            Confirm a booking first before RFID check-in.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Check-in Modal --}}
    <div id="checkInModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 px-4 py-6">
        <div class="mx-auto mt-20 max-w-lg rounded-3xl bg-white p-6 shadow-xl">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        RFID Check-in
                    </h2>
                    <p class="text-sm text-slate-500">
                        Scan an available RFID card for this guest.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="closeCheckInModal()"
                    class="rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                    ✕
                </button>
            </div>

            <div class="mb-5 rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Booking
                </p>
                <p id="modalBookingCode" class="mt-1 font-bold text-slate-900"></p>

                <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Guest
                </p>
                <p id="modalGuestName" class="mt-1 font-semibold text-slate-700"></p>
            </div>

            <form id="checkInForm" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                        RFID UID
                    </label>

                    <input
                        type="text"
                        id="rfid_uid"
                        name="rfid_uid"
                        required
                        autocomplete="off"
                        placeholder="Click here then scan RFID card..."
                        class="w-full rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                    Make sure the RFID card is already registered and currently available.
                </div>

                <div class="flex justify-end gap-2 pt-3">
                    <button
                        type="button"
                        onclick="closeCheckInModal()"
                        class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Cancel
                    </button>

                    <button class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                        Confirm Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCheckInModal(bookingId, bookingCode, guestName) {
            const modal = document.getElementById('checkInModal');
            const form = document.getElementById('checkInForm');
            const input = document.getElementById('rfid_uid');

            form.action = `/rfid-check-in/${bookingId}`;

            document.getElementById('modalBookingCode').innerText = bookingCode;
            document.getElementById('modalGuestName').innerText = guestName || 'No guest name';

            input.value = '';
            modal.classList.remove('hidden');

            setTimeout(() => {
                input.focus();
            }, 200);
        }

        function closeCheckInModal() {
            document.getElementById('checkInModal').classList.add('hidden');
            document.getElementById('rfid_uid').value = '';
        }
    </script>
</x-layouts.layout>
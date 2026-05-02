<x-layouts.layout>
    <div class="min-h-screen">
        <div class="">

            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        RFID Cards
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Register and manage RFID cards used for guest check-in and check-out.
                    </p>
                </div>

                <button
                    onclick="document.getElementById('createModal').classList.remove('hidden')"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700">
                    + Register RFID
                </button>
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

            <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Cards</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                </div>

                <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-5">
                    <p class="text-sm text-emerald-700">Available</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-800">{{ $stats['available'] }}</p>
                </div>

                <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5">
                    <p class="text-sm text-blue-700">Assigned</p>
                    <p class="mt-2 text-2xl font-bold text-blue-800">{{ $stats['assigned'] }}</p>
                </div>

                <div class="rounded-3xl border border-red-200 bg-red-50 p-5">
                    <p class="text-sm text-red-700">Lost</p>
                    <p class="mt-2 text-2xl font-bold text-red-800">{{ $stats['lost'] }}</p>
                </div>

                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5">
                    <p class="text-sm text-amber-700">Damaged</p>
                    <p class="mt-2 text-2xl font-bold text-amber-800">{{ $stats['damaged'] }}</p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <form method="GET" class="mb-5 grid gap-3 md:grid-cols-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search UID or remarks..."
                        class="rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">

                    <select
                        name="status"
                        class="rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">
                        <option value="">All Status</option>
                        <option value="available" @selected(request('status') === 'available')>Available</option>
                        <option value="assigned" @selected(request('status') === 'assigned')>Assigned</option>
                        <option value="lost" @selected(request('status') === 'lost')>Lost</option>
                        <option value="damaged" @selected(request('status') === 'damaged')>Damaged</option>
                    </select>

                    <div class="flex gap-2">
                        <button class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                            Filter
                        </button>

                        <a href="{{ route('rfid-cards.index') }}"
                           class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="overflow-hidden rounded-2xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">UID</th>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Active Guest</th>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Remarks</th>
                                <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($rfidCards as $card)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-900">{{ $card->uid }}</div>
                                        <div class="text-xs text-slate-400">Registered {{ $card->created_at->format('M d, Y') }}</div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold ring-1 {{ $card->status_badge_class }}">
                                            {{ ucfirst($card->status) }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        @if ($card->activeBooking && $card->activeBooking->guest)
                                            <div class="font-semibold text-slate-900">
                                                {{ $card->activeBooking->guest->first_name }}
                                                {{ $card->activeBooking->guest->last_name }}
                                            </div>
                                            <div class="text-xs text-slate-400">
                                                Booking #{{ $card->activeBooking->booking_code ?? $card->activeBooking->id }}
                                            </div>
                                        @else
                                            <span class="text-slate-400">No active guest</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ $card->remarks ?? '—' }}
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <button
                                            onclick="openEditModal(
                                                '{{ $card->id }}',
                                                '{{ $card->uid }}',
                                                '{{ $card->status }}',
                                                `{{ $card->remarks }}`
                                            )"
                                            class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100">
                                            Edit
                                        </button>

                                        <form
                                            method="POST"
                                            action="{{ route('rfid-cards.destroy', $card) }}"
                                            class="inline"
                                            onsubmit="return confirm('Delete this RFID card?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="rounded-xl border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center">
                                        <div class="text-sm font-semibold text-slate-700">No RFID cards found</div>
                                        <div class="mt-1 text-sm text-slate-400">Register your first RFID card to start using scan-based check-in.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $rfidCards->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div id="createModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 px-4 py-6">
        <div class="mx-auto mt-20 max-w-lg rounded-3xl bg-white p-6 shadow-xl">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Register RFID Card</h2>
                    <p class="text-sm text-slate-500">Click the UID field then scan the card.</p>
                </div>

                <button
                    onclick="document.getElementById('createModal').classList.add('hidden')"
                    class="rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                    ✕
                </button>
            </div>

            <form method="POST" action="{{ route('rfid-cards.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">RFID UID</label>
                    <input
                        type="text"
                        name="uid"
                        autofocus
                        required
                        placeholder="Scan RFID card..."
                        class="w-full rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Remarks</label>
                    <input
                        type="text"
                        name="remarks"
                        placeholder="Example: Front desk card #1"
                        class="w-full rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">
                </div>

                <div class="flex justify-end gap-2 pt-3">
                    <button
                        type="button"
                        onclick="document.getElementById('createModal').classList.add('hidden')"
                        class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Cancel
                    </button>

                    <button class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                        Save RFID
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 px-4 py-6">
        <div class="mx-auto mt-20 max-w-lg rounded-3xl bg-white p-6 shadow-xl">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Edit RFID Card</h2>
                    <p class="text-sm text-slate-500">Update card UID, status, or remarks.</p>
                </div>

                <button
                    onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                    ✕
                </button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">RFID UID</label>
                    <input
                        type="text"
                        id="edit_uid"
                        name="uid"
                        required
                        class="w-full rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Status</label>
                    <select
                        id="edit_status"
                        name="status"
                        required
                        class="w-full rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">
                        <option value="available">Available</option>
                        <option value="assigned">Assigned</option>
                        <option value="lost">Lost</option>
                        <option value="damaged">Damaged</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Remarks</label>
                    <input
                        type="text"
                        id="edit_remarks"
                        name="remarks"
                        class="w-full rounded-2xl border-slate-200 text-sm shadow-sm focus:border-slate-900 focus:ring-slate-900">
                </div>

                <div class="flex justify-end gap-2 pt-3">
                    <button
                        type="button"
                        onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Cancel
                    </button>

                    <button class="rounded-2xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                        Update RFID
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, uid, status, remarks) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            form.action = `/rfid-cards/${id}`;

            document.getElementById('edit_uid').value = uid;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_remarks').value = remarks === 'null' ? '' : remarks;

            modal.classList.remove('hidden');
        }
    </script>
</x-layouts.layout>
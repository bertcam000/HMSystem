<x-layouts.layout>
    <div class="min-h-screen">
        <div
            x-data="rfidFrontDesk()"
            x-init="init()"
            class="space-y-6"
        >
            {{-- Floating Toast --}}
            <div class="fixed top-5 right-5 z-50 w-full max-w-sm"
                 x-show="message"
                 x-transition:enter="transform ease-out duration-300"
                 x-transition:enter-start="translate-y-2 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-init="$watch('message', value => {
                    if (value) {
                        setTimeout(() => message = '', 2500)
                    }
                 })"
                 style="display: none;">

                <div class="flex items-center justify-between gap-3 rounded-2xl px-4 py-3 shadow-lg border"
                     :class="messageType === 'success'
                        ? 'bg-emerald-100 border-emerald-200 text-emerald-800'
                        : 'bg-red-100 border-red-200 text-red-800'">

                    <div class="flex items-center gap-2 text-sm font-semibold">
                        <span x-show="messageType === 'success'"></span>
                        <span x-show="messageType === 'error'"></span>
                        <span x-text="message"></span>
                    </div>

                    <button @click="message = ''"
                            class="text-lg font-bold leading-none hover:opacity-70">
                        ×
                    </button>
                </div>
            </div>

            {{-- Header --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Front Desk RFID</p>
                <h1 class="text-2xl font-black text-slate-900">RFID Check-in / Check-out</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Scan a registered RFID card. No page reload needed.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- Scanner --}}
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Scan RFID Card</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Scanner should send Enter after scan.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <label class="text-sm font-semibold text-slate-700">RFID UID</label>
                            <input type="text"
                                   x-ref="rfidInput"
                                   x-model="rfidUid"
                                   @keydown.enter.prevent="detectCard()"
                                   autofocus
                                   autocomplete="off"
                                   placeholder="Scan RFID card..."
                                   class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                   :disabled="loading">
                        </div>

                        <button type="button"
                                @click="detectCard()"
                                class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800 disabled:opacity-50"
                                :disabled="loading || !rfidUid">
                            <span x-show="!loading">Detect Card</span>
                            <span x-show="loading">Detecting...</span>
                        </button>
                    </div>

                    <div x-show="rfidCard"
                         x-transition
                         class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4"
                         style="display: none;">
                        <p class="text-xs font-semibold uppercase text-slate-500">Detected Card</p>

                        <div class="mt-2 space-y-2 text-sm">
                            <p>
                                <span class="font-semibold text-slate-600">UID:</span>
                                <span class="font-bold text-slate-900" x-text="detectedUid"></span>
                            </p>

                            <p>
                                <span class="font-semibold text-slate-600">Status:</span>

                                <span class="rounded-full px-3 py-1 text-xs font-bold"
                                      :class="rfidCard?.status === 'available'
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-blue-100 text-blue-700'"
                                      x-text="rfidCard?.status">
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Dynamic Panel --}}
                <div class="lg:col-span-2 rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">

                    <template x-if="!mode">
                        <div class="p-8 text-center">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-2xl">
                                💳
                            </div>

                            <h2 class="mt-4 text-xl font-black text-slate-900">
                                Waiting for RFID scan
                            </h2>

                            <p class="mt-2 text-sm text-slate-500">
                                Available card = check-in. Assigned card = check-out.
                            </p>
                        </div>
                    </template>

                    {{-- Check-in --}}
                    <template x-if="mode === 'check_in'">
                        <div>
                            <div class="border-b border-slate-200 bg-emerald-50 px-6 py-5">
                                <p class="text-sm font-bold text-emerald-700">Mode Detected</p>
                                <h2 class="text-xl font-black text-emerald-900">Check-in Guest</h2>
                                <p class="mt-1 text-sm text-emerald-700">
                                    RFID card is available. Select a booking to assign this card.
                                </p>
                            </div>

                            <div class="p-6">
                                <form method="POST"
                                      :action="selectedCheckInUrl"
                                      class="space-y-4"
                                      @submit="return selectedCheckInUrl ? confirm('Confirm RFID check-in?') : false;">
                                    @csrf

                                    <input type="hidden" name="rfid_uid" :value="detectedUid">

                                    <div>
                                        <label class="text-sm font-semibold text-slate-700">Booking / Guest</label>
                                        <select x-model="selectedCheckInUrl"
                                                class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                                required>
                                            <option value="">Select booking</option>

                                            <template x-for="booking in bookings" :key="booking.id">
                                                <option :value="booking.check_in_url"
                                                        x-text="`${booking.booking_code} - ${booking.guest_name} - ${booking.status}`">
                                                </option>
                                            </template>
                                        </select>
                                    </div>

                                    <template x-if="bookings.length === 0">
                                        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm font-medium text-amber-700">
                                            No reserved or confirmed bookings available.
                                        </div>
                                    </template>

                                    <button type="submit"
                                            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                                        Confirm Check-in
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>

                    {{-- Check-out --}}
                    <template x-if="mode === 'check_out' && booking">
                        <div>
                            <div class="border-b border-slate-200 bg-blue-50 px-6 py-5">
                                <p class="text-sm font-bold text-blue-700">Mode Detected</p>
                                <h2 class="text-xl font-black text-blue-900">Check-out Guest</h2>
                                <p class="mt-1 text-sm text-blue-700">
                                    RFID card is assigned to an active checked-in booking.
                                </p>
                            </div>

                            <div class="p-6 space-y-6">
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <p class="text-xs font-bold uppercase text-slate-500">Booking Code</p>
                                            <p class="mt-1 text-lg font-black text-slate-900" x-text="booking.booking_code"></p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-bold uppercase text-slate-500">Guest</p>
                                            <p class="mt-1 text-lg font-black text-slate-900" x-text="booking.guest_name"></p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-bold uppercase text-slate-500">Room/s</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-800" x-text="booking.rooms || 'No assigned room'"></p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-bold uppercase text-slate-500">Checked-in At</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-800" x-text="booking.checked_in_at"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-4 md:grid-cols-4">
                                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                        <p class="text-xs font-bold uppercase text-slate-500">Room Total</p>
                                        <p class="mt-1 text-lg font-black text-slate-900">
                                            ₱<span x-text="booking.room_total"></span>
                                        </p>
                                    </div>

                                    <div class="rounded-2xl border border-orange-200 bg-orange-50 p-4">
                                        <p class="text-xs font-bold uppercase text-orange-600">Folio Charges</p>
                                        <p class="mt-1 text-lg font-black text-orange-700">
                                            ₱<span x-text="booking.charges_total"></span>
                                        </p>
                                    </div>

                                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                                        <p class="text-xs font-bold uppercase text-emerald-600">Paid</p>
                                        <p class="mt-1 text-lg font-black text-emerald-700">
                                            ₱<span x-text="booking.paid_amount"></span>
                                        </p>
                                    </div>

                                    <div class="rounded-2xl border p-4"
                                         :class="booking.raw_balance > 0 ? 'border-red-200 bg-red-50' : 'border-emerald-200 bg-emerald-50'">
                                        <p class="text-xs font-bold uppercase"
                                           :class="booking.raw_balance > 0 ? 'text-red-600' : 'text-emerald-600'">
                                            Balance
                                        </p>
                                        <p class="mt-1 text-lg font-black"
                                           :class="booking.raw_balance > 0 ? 'text-red-700' : 'text-emerald-700'">
                                            ₱<span x-text="booking.balance"></span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                                    <a :href="booking.folio_url"
                                       class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-4 py-3 text-sm font-bold text-white hover:bg-orange-700">
                                        Open Folio / Add Charges
                                    </a>

                                    <a :href="booking.payment_url"
                                       class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                                        Add / Settle Payment
                                    </a>

                                    <template x-if="booking.raw_balance > 0">
                                        <div class="w-full rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm font-medium text-amber-700">
                                            Guest still has remaining balance. Settle payment first before checkout.
                                        </div>
                                    </template>

                                    <template x-if="booking.raw_balance <= 0">
                                        <form method="POST"
                                              :action="booking.check_out_url"
                                              onsubmit="return confirm('Confirm RFID check-out for this guest?')">
                                            @csrf

                                            <button class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white hover:bg-slate-800">
                                                Confirm Check-out
                                            </button>
                                        </form>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>

    <script>
        function rfidFrontDesk() {
            return {
                rfidUid: '',
                detectedUid: '',
                rfidCard: null,
                mode: null,
                bookings: [],
                booking: null,
                selectedCheckInUrl: '',
                loading: false,
                message: '',
                messageType: 'error',
                toastTimer: null,

                init() {
                    this.focusScanner();
                },

                focusScanner() {
                    this.$nextTick(() => {
                        this.$refs.rfidInput?.focus();
                    });
                },

                showToast(type, text) {
                    clearTimeout(this.toastTimer);

                    this.messageType = type;
                    this.message = text;

                    this.toastTimer = setTimeout(() => {
                        this.message = '';
                    }, 2500);
                },

                async detectCard() {
                    const uid = this.rfidUid.trim();

                    if (!uid || this.loading) {
                        return;
                    }

                    this.loading = true;
                    this.message = '';

                    try {
                        const response = await fetch('{{ route('rfid.front-desk.detect') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                rfid_uid: uid,
                            }),
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'RFID detect failed.');
                        }

                        this.detectedUid = data.rfid_uid;
                        this.rfidCard = {
                            status: data.card_status,
                        };
                        this.mode = data.mode;

                        this.bookings = data.bookings || [];
                        this.booking = data.booking || null;
                        this.selectedCheckInUrl = '';

                        this.showToast(
                            'success',
                            data.mode === 'check_in'
                                ? 'Available RFID detected. Select booking for check-in.'
                                : 'Assigned RFID detected. Guest details loaded.'
                        );

                    } catch (error) {
                        this.mode = null;
                        this.rfidCard = null;
                        this.bookings = [];
                        this.booking = null;

                        this.showToast('error', error.message);
                    } finally {
                        this.rfidUid = '';
                        this.loading = false;
                        this.focusScanner();
                    }
                },
            }
        }
    </script>
</x-layouts.layout>
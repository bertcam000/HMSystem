<x-layouts.layout>
    <div class="min-h-screen">
        <div class="space-y-6">

            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Hotel Operations</p>
                        <h1 class="text-2xl font-black text-slate-900">Amenities & Consumables Requests</h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Encode guest requests and automatically charge them to the booking folio.
                        </p>
                    </div>

                    <form method="GET" class="flex flex-col gap-2 sm:flex-row">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search guest, booking, item..."
                               class="rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900">

                        <select name="status"
                                class="rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900">
                            <option value="">All Status</option>
                            @foreach (['pending', 'approved', 'fulfilled', 'rejected', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>

                        <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white hover:bg-slate-800">
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- Create Form --}}
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-slate-900">New Request</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        For checked-in guests only.
                    </p>

                    <form method="POST" action="{{ route('amenity-requests.store') }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Booking / Guest</label>
                            <select name="booking_id"
                                    class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                    required>
                                <option value="">Select checked-in booking</option>
                                @foreach ($activeBookings as $booking)
                                    <option value="{{ $booking->id }}" @selected(old('booking_id') == $booking->id)>
                                        {{ $booking->booking_code }}
                                        -
                                        {{ $booking->guest->first_name ?? '' }}
                                        {{ $booking->guest->last_name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div
                            x-data="{
                                selectedItem: '{{ old('amenity_item_id') }}',
                                quantity: '{{ old('quantity', 1) }}',
                                items: @js($amenityItems->map(fn ($item) => [
                                    'id' => $item->id,
                                    'name' => $item->name,
                                    'category' => $item->category,
                                    'unit_price' => (float) $item->unit_price,
                                    'stock_quantity' => $item->stock_quantity,
                                    'minimum_stock' => $item->minimum_stock,
                                    'is_chargeable' => (bool) $item->is_chargeable,
                                    'stock_status' => $item->stock_status,
                                ])),
                                get item() {
                                    return this.items.find(i => i.id == this.selectedItem);
                                },
                                get total() {
                                    if (!this.item) return 0;
                                    return Number(this.item.unit_price) * Number(this.quantity || 0);
                                },
                                get quantityTooHigh() {
                                    if (!this.item) return false;
                                    return Number(this.quantity || 0) > Number(this.item.stock_quantity);
                                }
                            }"
                            class="space-y-4"
                        >
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Item</label>
                                <select name="amenity_item_id"
                                        x-model="selectedItem"
                                        class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                        required>
                                    <option value="">Select item</option>

                                    @foreach ($amenityItems as $item)
                                        <option value="{{ $item->id }}"
                                                @selected(old('amenity_item_id') == $item->id)
                                                @disabled($item->stock_quantity <= 0)>
                                            {{ $item->name }}
                                            -
                                            ₱{{ number_format($item->unit_price, 2) }}
                                            -
                                            Stock: {{ $item->stock_quantity }}
                                            @if ($item->stock_quantity <= 0)
                                                - OUT OF STOCK
                                            @elseif ($item->stock_quantity < $item->minimum_stock)
                                                - LOW STOCK
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                <p class="mt-1 text-xs text-slate-400">
                                    Out of stock items are disabled.
                                </p>
                            </div>

                            <template x-if="item">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Category</span>
                                        <span class="font-bold text-slate-800" x-text="item.category"></span>
                                    </div>

                                    <div class="mt-2 flex justify-between">
                                        <span class="text-slate-500">Unit Price</span>
                                        <span class="font-bold text-slate-800">
                                            ₱<span x-text="Number(item.unit_price).toFixed(2)"></span>
                                        </span>
                                    </div>

                                    <div class="mt-2 flex justify-between">
                                        <span class="text-slate-500">Stock</span>
                                        <span class="font-bold"
                                              :class="{
                                                  'text-red-600': item.stock_status === 'out_of_stock',
                                                  'text-amber-600': item.stock_status === 'low_stock',
                                                  'text-emerald-600': item.stock_status === 'in_stock'
                                              }">
                                            <span x-text="item.stock_quantity"></span>
                                            <span x-show="item.stock_status === 'out_of_stock'">left · OUT OF STOCK</span>
                                            <span x-show="item.stock_status === 'low_stock'">left · LOW STOCK</span>
                                            <span x-show="item.stock_status === 'in_stock'">left · IN STOCK</span>
                                        </span>
                                    </div>

                                    <div class="mt-2 flex justify-between">
                                        <span class="text-slate-500">Minimum Stock</span>
                                        <span class="font-bold text-slate-800" x-text="item.minimum_stock"></span>
                                    </div>

                                    <div class="mt-2 flex justify-between">
                                        <span class="text-slate-500">Billing</span>
                                        <span class="font-bold"
                                              :class="item.is_chargeable ? 'text-orange-600' : 'text-emerald-600'"
                                              x-text="item.is_chargeable ? 'Chargeable' : 'Free'">
                                        </span>
                                    </div>

                                    <div class="mt-2 flex justify-between border-t border-slate-200 pt-2">
                                        <span class="text-slate-500">Estimated Total</span>
                                        <span class="font-black text-slate-900">
                                            ₱<span x-text="total.toFixed(2)"></span>
                                        </span>
                                    </div>
                                </div>
                            </template>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Quantity</label>
                                <input type="number"
                                       name="quantity"
                                       x-model="quantity"
                                       step="1"
                                       min="1"
                                       value="{{ old('quantity', 1) }}"
                                       class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                       required>

                                <template x-if="quantityTooHigh">
                                    <p class="mt-1 text-xs font-semibold text-red-600">
                                        Quantity exceeds available stock.
                                    </p>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Notes</label>
                            <textarea name="notes"
                                      rows="3"
                                      placeholder="Optional request notes..."
                                      class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900">{{ old('notes') }}</textarea>
                        </div>

                        <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800">
                            Create Request
                        </button>
                    </form>
                </div>

                {{-- Table --}}
                <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <h2 class="text-lg font-bold text-slate-900">Request List</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Guest</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Item</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($requests as $requestItem)
                                    <tr>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-bold text-slate-900">
                                                {{ $requestItem->booking->guest->first_name ?? '' }}
                                                {{ $requestItem->booking->guest->last_name ?? '' }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ $requestItem->booking->booking_code ?? 'N/A' }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-semibold text-slate-800">
                                                {{ $requestItem->item_name }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ ucfirst($requestItem->category) }}
                                                · Qty {{ number_format($requestItem->quantity, 2) }}
                                                · ₱{{ number_format($requestItem->unit_price, 2) }}
                                            </div>

                                            @if ($requestItem->amenityItem)
                                                <div class="mt-1 text-xs text-slate-400">
                                                    Stock item: {{ $requestItem->amenityItem->name }}
                                                </div>
                                            @endif

                                            @if ($requestItem->folioCharge)
                                                <a href="{{ route('bookings.folio', $requestItem->booking) }}"
                                                   class="mt-1 inline-block text-xs font-bold text-orange-600 hover:underline">
                                                    Added to Folio: {{ $requestItem->folioCharge->charge_code }}
                                                </a>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right text-sm font-bold text-slate-900">
                                            @if ($requestItem->is_chargeable)
                                                ₱{{ number_format($requestItem->total_amount, 2) }}
                                            @else
                                                <span class="text-slate-400">Free</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm">
                                            @php
                                                $badge = match ($requestItem->status) {
                                                    'pending' => 'bg-amber-100 text-amber-700',
                                                    'approved' => 'bg-blue-100 text-blue-700',
                                                    'fulfilled' => 'bg-emerald-100 text-emerald-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                    default => 'bg-slate-100 text-slate-700',
                                                };
                                            @endphp

                                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $badge }}">
                                                {{ ucfirst($requestItem->status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex flex-col items-end gap-2">
                                                @if ($requestItem->status === 'pending')
                                                    <form method="POST" action="{{ route('amenity-requests.approve', $requestItem) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-bold text-white hover:bg-blue-700">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif

                                                @if (in_array($requestItem->status, ['pending', 'approved']))
                                                    <form method="POST" action="{{ route('amenity-requests.fulfill', $requestItem) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-bold text-white hover:bg-emerald-700">
                                                            Fulfill
                                                        </button>
                                                    </form>

                                                    <form method="POST"
                                                          action="{{ route('amenity-requests.reject', $requestItem) }}"
                                                          onsubmit="return confirm('Reject this request?')">
                                                        @csrf
                                                        @method('PATCH')

                                                        <input type="hidden" name="rejection_reason" value="Rejected by staff.">

                                                        <button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-bold text-white hover:bg-red-700">
                                                            Reject
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($requestItem->status === 'fulfilled')
                                                    <a href="{{ route('bookings.folio', $requestItem->booking) }}"
                                                       class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white hover:bg-slate-800">
                                                        View Folio
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                                            No amenity or consumable requests yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
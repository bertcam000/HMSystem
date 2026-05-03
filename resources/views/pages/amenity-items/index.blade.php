<x-layouts.layout>
    <div class="min-h-screen">
        <div class="space-y-6">

            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700">
                    {{ session('success') }}
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

            {{-- Header --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Inventory Master List</p>
                        <h1 class="text-2xl font-black text-slate-900">Amenity & Consumable Items</h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Manage reusable items, prices, and stock levels for guest requests.
                        </p>
                    </div>

                    <form method="GET" class="flex flex-col gap-2 sm:flex-row">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search item..."
                               class="rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900">

                        <select name="category"
                                class="rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900">
                            <option value="">All Categories</option>
                            @foreach (['amenity', 'consumable', 'service', 'other'] as $category)
                                <option value="{{ $category }}" @selected(request('category') === $category)>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>

                        <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white hover:bg-slate-800">
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            {{-- Stock Summary --}}
            @php
                $totalItems = \App\Models\AmenityItem::count();

                $lowStockCount = \App\Models\AmenityItem::whereColumn('stock_quantity', '<', 'minimum_stock')
                    ->where('stock_quantity', '>', 0)
                    ->count();

                $outOfStockCount = \App\Models\AmenityItem::where('stock_quantity', '<=', 0)
                    ->count();
            @endphp

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Total Items</p>
                    <h2 class="mt-2 text-3xl font-black text-slate-900">
                        {{ $totalItems }}
                    </h2>
                    <p class="mt-1 text-xs text-slate-400">
                        All amenity and consumable records.
                    </p>
                </div>

                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-amber-700">Low Stock</p>
                    <h2 class="mt-2 text-3xl font-black text-amber-700">
                        {{ $lowStockCount }}
                    </h2>
                    <p class="mt-1 text-xs text-amber-600">
                        Items below minimum stock level.
                    </p>
                </div>

                <div class="rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">Out of Stock</p>
                    <h2 class="mt-2 text-3xl font-black text-red-700">
                        {{ $outOfStockCount }}
                    </h2>
                    <p class="mt-1 text-xs text-red-600">
                        Items unavailable for guest requests.
                    </p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- Create Item --}}
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-slate-900">Add New Item</h2>

                    <form method="POST" action="{{ route('amenity-items.store') }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Item Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Extra towel, bottled water..."
                                   class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                   required>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Category</label>
                            <select name="category"
                                    class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                    required>
                                <option value="amenity">Amenity</option>
                                <option value="consumable">Consumable</option>
                                <option value="service">Service</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Unit Price</label>
                                <input type="number"
                                       name="unit_price"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('unit_price', 0) }}"
                                       class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                       required>
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Stock</label>
                                <input type="number"
                                       name="stock_quantity"
                                       min="0"
                                       value="{{ old('stock_quantity', 0) }}"
                                       class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                       required>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Minimum Stock</label>
                            <input type="number"
                                   name="minimum_stock"
                                   min="0"
                                   value="{{ old('minimum_stock', 5) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                   required>
                        </div>

                        <label class="flex items-center gap-2 rounded-xl border border-slate-200 p-3">
                            <input type="checkbox"
                                   name="is_chargeable"
                                   value="1"
                                   checked
                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                            <span class="text-sm font-semibold text-slate-700">Chargeable</span>
                        </label>

                        <label class="flex items-center gap-2 rounded-xl border border-slate-200 p-3">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   checked
                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                            <span class="text-sm font-semibold text-slate-700">Active</span>
                        </label>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Description</label>
                            <textarea name="description"
                                      rows="3"
                                      class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900">{{ old('description') }}</textarea>
                        </div>

                        <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800">
                            Save Item
                        </button>
                    </form>
                </div>

                {{-- Items Table --}}
                <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <h2 class="text-lg font-bold text-slate-900">Item List</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Category</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Price</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase text-slate-500">Stock</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase text-slate-500">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse ($items as $item)
                                    @php
                                        $stockBadge = match ($item->stock_status) {
                                            'out_of_stock' => 'bg-red-100 text-red-700',
                                            'low_stock' => 'bg-amber-100 text-amber-700',
                                            default => 'bg-emerald-100 text-emerald-700',
                                        };

                                        $rowClass = match ($item->stock_status) {
                                            'out_of_stock' => 'bg-red-50/60',
                                            'low_stock' => 'bg-amber-50/60',
                                            default => '',
                                        };
                                    @endphp

                                    <tr x-data="{ edit: false }" class="{{ $rowClass }}">
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-bold text-slate-900">
                                                {{ $item->name }}
                                            </div>

                                            @if ($item->description)
                                                <div class="text-xs text-slate-500">
                                                    {{ $item->description }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm">
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                                {{ ucfirst($item->category) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-right text-sm font-bold text-slate-900">
                                            ₱{{ number_format($item->unit_price, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-center text-sm">
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $stockBadge }}">
                                                    {{ $item->stock_quantity }} left
                                                </span>

                                                @if ($item->stock_status === 'low_stock')
                                                    <span class="text-xs font-semibold text-amber-600">
                                                        Low stock
                                                    </span>
                                                @elseif ($item->stock_status === 'out_of_stock')
                                                    <span class="text-xs font-semibold text-red-600">
                                                        Out of stock
                                                    </span>
                                                @else
                                                    <span class="text-xs font-semibold text-emerald-600">
                                                        In stock
                                                    </span>
                                                @endif

                                                <span class="text-[11px] text-slate-400">
                                                    Min: {{ $item->minimum_stock }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center text-sm">
                                            @if ($item->is_active)
                                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                                    Active
                                                </span>
                                            @else
                                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                                    Inactive
                                                </span>
                                            @endif

                                            @if (! $item->is_chargeable)
                                                <div class="mt-1 text-xs font-semibold text-slate-400">
                                                    Free
                                                </div>
                                            @else
                                                <div class="mt-1 text-xs font-semibold text-orange-500">
                                                    Chargeable
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right text-sm">
                                            <div class="flex justify-end gap-2">
                                                <button type="button"
                                                        @click="edit = true"
                                                        class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-bold text-white hover:bg-blue-700">
                                                    Edit
                                                </button>

                                                <form method="POST"
                                                      action="{{ route('amenity-items.destroy', $item) }}"
                                                      onsubmit="return confirm('Delete this item?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-bold text-white hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- Edit Modal --}}
                                            <div x-show="edit"
                                                 x-cloak
                                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
                                                <div @click.away="edit = false"
                                                     class="w-full max-w-xl rounded-3xl bg-white p-6 text-left shadow-xl">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="text-lg font-black text-slate-900">Edit Item</h3>

                                                        <button type="button"
                                                                @click="edit = false"
                                                                class="text-slate-400 hover:text-slate-700">
                                                            ✕
                                                        </button>
                                                    </div>

                                                    <form method="POST"
                                                          action="{{ route('amenity-items.update', $item) }}"
                                                          class="mt-6 space-y-4">
                                                        @csrf
                                                        @method('PATCH')

                                                        <div>
                                                            <label class="text-sm font-semibold text-slate-700">Item Name</label>
                                                            <input type="text"
                                                                   name="name"
                                                                   value="{{ $item->name }}"
                                                                   class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                                                   required>
                                                        </div>

                                                        <div>
                                                            <label class="text-sm font-semibold text-slate-700">Category</label>
                                                            <select name="category"
                                                                    class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                                                    required>
                                                                @foreach (['amenity', 'consumable', 'service', 'other'] as $category)
                                                                    <option value="{{ $category }}" @selected($item->category === $category)>
                                                                        {{ ucfirst($category) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-3">
                                                            <div>
                                                                <label class="text-sm font-semibold text-slate-700">Unit Price</label>
                                                                <input type="number"
                                                                       name="unit_price"
                                                                       step="0.01"
                                                                       min="0"
                                                                       value="{{ $item->unit_price }}"
                                                                       class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                                                       required>
                                                            </div>

                                                            <div>
                                                                <label class="text-sm font-semibold text-slate-700">Stock</label>
                                                                <input type="number"
                                                                       name="stock_quantity"
                                                                       min="0"
                                                                       value="{{ $item->stock_quantity }}"
                                                                       class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                                                       required>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="text-sm font-semibold text-slate-700">Minimum Stock</label>
                                                            <input type="number"
                                                                   name="minimum_stock"
                                                                   min="0"
                                                                   value="{{ $item->minimum_stock }}"
                                                                   class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900"
                                                                   required>
                                                        </div>

                                                        <label class="flex items-center gap-2 rounded-xl border border-slate-200 p-3">
                                                            <input type="checkbox"
                                                                   name="is_chargeable"
                                                                   value="1"
                                                                   @checked($item->is_chargeable)
                                                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">

                                                            <span class="text-sm font-semibold text-slate-700">
                                                                Chargeable
                                                            </span>
                                                        </label>

                                                        <label class="flex items-center gap-2 rounded-xl border border-slate-200 p-3">
                                                            <input type="checkbox"
                                                                   name="is_active"
                                                                   value="1"
                                                                   @checked($item->is_active)
                                                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">

                                                            <span class="text-sm font-semibold text-slate-700">
                                                                Active
                                                            </span>
                                                        </label>

                                                        <div>
                                                            <label class="text-sm font-semibold text-slate-700">Description</label>
                                                            <textarea name="description"
                                                                      rows="3"
                                                                      class="mt-1 w-full rounded-xl border-slate-300 text-sm focus:border-slate-900 focus:ring-slate-900">{{ $item->description }}</textarea>
                                                        </div>

                                                        <div class="flex justify-end gap-2">
                                                            <button type="button"
                                                                    @click="edit = false"
                                                                    class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">
                                                                Cancel
                                                            </button>

                                                            <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white hover:bg-slate-800">
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                            No amenity items yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.layout>
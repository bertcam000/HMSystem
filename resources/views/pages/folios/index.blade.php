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
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Guest Folio</p>
                        <h1 class="text-2xl font-bold text-slate-900">
                            {{ $booking->booking_code }}
                        </h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Guest:
                            <span class="font-semibold text-slate-700">
                                {{ $booking->guest->first_name ?? '' }}
                                {{ $booking->guest->last_name ?? '' }}
                            </span>
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('bookings') }}"
                           class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Back
                        </a>

                        <button onclick="window.print()"
                                class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                            Print Folio
                        </button>
                    </div>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Room Total</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">
                        ₱{{ number_format($booking->total_price, 2) }}
                    </h2>
                </div>

                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Extra Charges</p>
                    <h2 class="mt-2 text-2xl font-bold text-orange-600">
                        ₱{{ number_format($activeChargesTotal, 2) }}
                    </h2>
                </div>

                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Paid</p>
                    <h2 class="mt-2 text-2xl font-bold text-emerald-600">
                        ₱{{ number_format($paidTotal, 2) }}
                    </h2>
                </div>

                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Balance</p>
                    <h2 class="mt-2 text-2xl font-bold {{ $balance > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        ₱{{ number_format($balance, 2) }}
                    </h2>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- Add Charge Form --}}
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-slate-900">Add Charge</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Add amenities, bar orders, damages, or services.
                    </p>

                    <form method="POST"
                          action="{{ route('bookings.folio.charges.store', $booking) }}"
                          class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Category</label>
                            <select name="category"
                                    class="mt-1 w-full rounded-xl border-slate-300 focus:border-slate-900 focus:ring-slate-900">
                                <option value="amenity">Amenity</option>
                                <option value="consumable">Consumable</option>
                                <option value="bar">Bar</option>
                                <option value="food">Food</option>
                                <option value="damage">Damage</option>
                                <option value="service">Service</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Description</label>
                            <input type="text"
                                   name="description"
                                   value="{{ old('description') }}"
                                   placeholder="Example: Extra towel, Coke, Room damage"
                                   class="mt-1 w-full rounded-xl border-slate-300 focus:border-slate-900 focus:ring-slate-900">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Qty</label>
                                <input type="number"
                                       step="0.01"
                                       min="0.01"
                                       name="quantity"
                                       value="{{ old('quantity', 1) }}"
                                       class="mt-1 w-full rounded-xl border-slate-300 focus:border-slate-900 focus:ring-slate-900">
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Unit Price</label>
                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       name="unit_price"
                                       value="{{ old('unit_price') }}"
                                       class="mt-1 w-full rounded-xl border-slate-300 focus:border-slate-900 focus:ring-slate-900">
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800">
                            Add to Folio
                        </button>
                    </form>
                </div>

                {{-- Charges Table --}}
                <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <h2 class="text-lg font-bold text-slate-900">Folio Charges</h2>
                        <p class="text-sm text-slate-500">
                            Active and voided charges for this booking.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-500">Description</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Amount</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase text-slate-500">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse ($booking->folioCharges as $charge)
                                    <tr class="{{ $charge->is_void ? 'bg-slate-50 opacity-70' : '' }}">
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-700">
                                            {{ $charge->charge_code }}
                                        </td>

                                        <td class="px-6 py-4 text-sm">
                                            <span class="rounded-full px-3 py-1 text-xs font-bold
                                                {{ $charge->is_void ? 'bg-slate-200 text-slate-600' : 'bg-orange-100 text-orange-700' }}">
                                                {{ ucfirst($charge->category) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $charge->description }}

                                            @if ($charge->is_void)
                                                <div class="mt-1 text-xs text-red-500">
                                                    Voided: {{ $charge->void_reason }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right text-sm text-slate-700">
                                            {{ number_format($charge->quantity, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-right text-sm text-slate-700">
                                            ₱{{ number_format($charge->unit_price, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-right text-sm font-bold
                                            {{ $charge->is_void ? 'text-slate-400 line-through' : 'text-slate-900' }}">
                                            ₱{{ number_format($charge->amount, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            @if (!$charge->is_void)
                                                <form method="POST"
                                                      action="{{ route('folio-charges.void', $charge) }}"
                                                      onsubmit="return confirm('Void this charge?')"
                                                      class="flex gap-2 justify-end">
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="text"
                                                           name="void_reason"
                                                           required
                                                           placeholder="Reason"
                                                           class="w-32 rounded-lg border-slate-300 text-xs">

                                                    <button type="submit"
                                                            class="rounded-lg bg-red-600 px-3 py-2 text-xs font-bold text-white hover:bg-red-700">
                                                        Void
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-slate-400">Voided</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-sm text-slate-500">
                                            No folio charges yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tfoot class="bg-slate-50">
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-slate-700">
                                        Active Charges Total
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-slate-900">
                                        ₱{{ number_format($activeChargesTotal, 2) }}
                                    </td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-slate-700">
                                        Grand Total
                                    </td>
                                    <td class="px-6 py-4 text-right text-lg font-black text-slate-900">
                                        ₱{{ number_format($grandTotal, 2) }}
                                    </td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-slate-700">
                                        Remaining Balance
                                    </td>
                                    <td class="px-6 py-4 text-right text-lg font-black {{ $balance > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                        ₱{{ number_format($balance, 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.layout>
<?php

use App\Models\Booking;
use App\Models\Payment;
use Livewire\Volt\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public $booking;

    public $amount = '';
    public $type = 'deposit';
    public $payment_method = 'cash';
    public $reference_number = '';
    public $notes = '';

    public function mount($booking)
    {
        $this->booking = Booking::findOrFail($booking);
    }

    public function rules()
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . max((float) $this->booking->balance, 0.01),
            ],
            'type' => ['required', Rule::in(['deposit', 'additional', 'full_payment', 'remaining_balance'])],
            'payment_method' => ['required', Rule::in(['cash', 'gcash', 'bank_transfer', 'card'])],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function savePayment()
    {
        $this->validate();

        DB::transaction(function () {
            Payment::create([
                'booking_id' => $this->booking->id,
                'amount' => $this->amount,
                'payment_method' => $this->payment_method,
                'type' => $this->type,
                'reference_number' => $this->reference_number ?: null,
                'notes' => $this->notes ?: null,
                'payment_date' => now(),
            ]);

            $this->booking->refresh();

            $paidAmount = $this->booking->payments()->sum('amount');
            $balance = max((float) $this->booking->total_price - (float) $paidAmount, 0);

            $paymentStatus = 'unpaid';

            if ($paidAmount > 0 && $paidAmount < $this->booking->total_price) {
                $paymentStatus = 'partial';
            } elseif ($paidAmount >= $this->booking->total_price) {
                $paymentStatus = 'paid';
            }

            $bookingStatus = $this->booking->status;
            if ($this->booking->status === 'pending' && $paidAmount > 0) {
                $bookingStatus = 'confirmed';
            }

            $this->booking->update([
                'paid_amount' => $paidAmount,
                'balance' => $balance,
                'payment_status' => $paymentStatus,
                'status' => $bookingStatus,
            ]);
        });

        $this->booking->refresh();

        $this->reset(['amount', 'type', 'payment_method', 'reference_number', 'notes']);
        $this->type = 'deposit';
        $this->payment_method = 'cash';

        session()->flash('success', 'Payment added successfully.');

        return redirect('/booking/result/'. $this->booking->id );

        $this->dispatch('close-payment-modal');
    }
};
?>

<form wire:submit.prevent="savePayment" class="space-y-5">
    

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Payment Amount</label>
            <input
                type="number"
                step="0.01"
                wire:model.live="amount"
                placeholder="Enter amount"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-slate-400"
            >
            @error('amount') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Payment Type</label>
            <select
                wire:model.live="type"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-slate-400"
            >
                <option value="deposit">Deposit</option>
                <option value="additional">Additional</option>
                <option value="full_payment">Full Payment</option>
                <option value="remaining_balance">Remaining Balance</option>
            </select>
            @error('type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Payment Method</label>
            <select
                wire:model.live="payment_method"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-slate-400"
            >
                <option value="cash">Cash</option>
                <option value="gcash">GCash</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="card">Card</option>
            </select>
            @error('payment_method') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Reference Number</label>
            <input
                type="text"
                wire:model.live="reference_number"
                placeholder="Optional reference no."
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-slate-400"
            >
            @error('reference_number') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Notes</label>
        <textarea
            rows="4"
            wire:model.live="notes"
            placeholder="Add payment notes..."
            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-slate-400"
        ></textarea>
        @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <button
            type="button"
            x-on:click="$dispatch('close-payment-modal')"
            class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
        >
            Cancel
        </button>

        <button
            type="submit"
            class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
        >
            Save Payment
        </button>
    </div>
</form>
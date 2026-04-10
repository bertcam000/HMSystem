<?php

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Booking;
use App\Models\BookingRoom;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;

new class extends Component {

    public $guest;

    public $source;
    public $adult;
    public $child;
    public $check_in;
    public $check_out;

    public $reservation;

    public $roomTypeId;

    public $selectedRooms = [];

    public $roomTypes = [];

    public function mount()
    {
        $this->roomTypes = RoomType::orderBy('name')->get();
    }

    public function getRoomsProperty()
    {
        if (!$this->roomTypeId || !$this->check_in || !$this->check_out) {
            return collect();
        }

        return Room::with('roomType')
            ->where('room_type_id', $this->roomTypeId)
            ->where('status', 'Available')
            ->whereDoesntHave('bookings', function ($query) {
                $query->whereIn('status', ['reserved', 'confirmed', 'checked_in'])
                    ->where(function ($q) {
                        $q->where('check_in_date', '<', $this->check_out)
                        ->where('check_out_date', '>', $this->check_in);
                    });
            })
            ->orderBy('room_number')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Selected Rooms
    |--------------------------------------------------------------------------
    */

    public function getSelectedRoomDetailsProperty()
    {
        return $this->rooms->whereIn('id', $this->selectedRooms);
    }

    /*
    |--------------------------------------------------------------------------
    | Nights
    |--------------------------------------------------------------------------
    */

    public function getNightsProperty()
    {
        if (!$this->check_in || !$this->check_out) {
            return 0;
        }

        return Carbon::parse($this->check_in)
            ->diffInDays(Carbon::parse($this->check_out));
    }

    /*
    |--------------------------------------------------------------------------
    | Subtotal
    |--------------------------------------------------------------------------
    */

    public function getSubtotalProperty()
    {
        $total = 0;

        foreach ($this->selectedRoomDetails as $room) {
            $total += $room->roomType->price;
        }

        return $total * $this->nights;
    }

    /*
    |--------------------------------------------------------------------------
    | VAT
    |--------------------------------------------------------------------------
    */

    public function getTaxProperty()
    {
        return $this->subtotal * 0.12;
    }

    /*
    |--------------------------------------------------------------------------
    | Service Charge
    |--------------------------------------------------------------------------
    */

    public function getServiceChargeProperty()
    {
        return $this->subtotal * 0.10;
    }

    /*
    |--------------------------------------------------------------------------
    | Total
    |--------------------------------------------------------------------------
    */

    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax + $this->service_charge;
    }

    /*
    |--------------------------------------------------------------------------
    | Save Reservation
    |--------------------------------------------------------------------------
    */

    public function saveReservation()
    {
        $this->validate([
            'guest' => 'required',
            'source' => 'required',
            'adult' => 'nullable',
            'child' => 'nullable',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'selectedRooms' => 'required|array|min:1'
        ]);

        DB::transaction(function () {

            $this->reservation = booking::create([

                'booking_code' => Booking::generateReservationCode(),

                'guest_id' => $this->guest,

                'source' => $this->source,

                'adult' => $this->adult,

                'children' => $this->child,

                'check_in_date' => $this->check_in,

                'check_out_date' => $this->check_out,

                'balance' => $this->total,

                'subtotal' => $this->subtotal,

                'tax' => $this->tax,

                'service_charge' => $this->service_charge,

                'total_price' => $this->total,

                'status' => 'reserved'

            ]);

            foreach ($this->selectedRooms as $roomId) {

                BookingRoom::create([
                    'booking_id' => $this->reservation->id,
                    'room_id' => $roomId
                ]);

            }

        });

        session()->flash('success', 'Reservation created successfully');

        return redirect('/booking/result/'. $this->reservation->id);
    }

};
?>
<div class="bg-white p-10 rounded-lg" @click.away="addBooking = false">
    <form wire:submit.prevent="saveReservation">
        <section class="grid lg:grid-cols-5 gap-5">
            <div class="col-span-3 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">New Booking</h2>
                <div class="space-y-4 mt-4">
                    <div>
                        <x-select
                            label="Select Guest"
                            placeholder="Search guest..."
                            :async-data="route('guest.search')"
                            option-label="label"
                            option-value="id"
                            wire:model.live="guest"
                        />
                    </div>
                    

                    <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
                        <x-datetime-picker
                            label="Select Check In Date"
                            placeholder="1/2/2026"
                            wire:model="check_in"
                            without-time
                            :min="now()->subDays(7)->hours(12)->minutes(30)"
                        />
                        <x-datetime-picker
                            label="Select Check Out Date"
                            placeholder="1/2/2026"
                            wire:model="check_out"
                            without-time
                            :min="now()->subDays(7)->hours(12)->minutes(30)"
                        />
                    </div>

                    <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
                        <x-number wire:model="adult" label="How many Adults?" placeholder="0" />
                        <x-number wire:model="child" label="How many Children?" placeholder="0" />
                    </div>

                    <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
                        
                        <x-native-select
                            label="Select Source"
                            wire:model="source"
                            placeholder="Select one status"
                            :options="['Online', 'Phone', 'Walk-in']"
                        />
                    </div>

                    <div>
                        <x-textarea label="Request" placeholder="write your request" />
                    </div>

                    <div>
                        <label for="" class="text-gray-500 text-sm">Select Room Type</label>
                        <select
                            wire:model.live="roomTypeId"
                            class="w-full border rounded-lg px-3 py-2 border-gray-400/40"
                        >

                            <option value="">
                                Choose Room Type
                            </option>

                            @foreach($roomTypes as $type)

                                <option value="{{ $type->id }}">
                                    {{ $type->name }}
                                    (₱{{ number_format($type->price) }})
                                </option>

                            @endforeach

                        </select>
                    </div>
                    
                    <div class="">

                        @if($this->rooms->count())

                            <div class="grid md:grid-cols-2 gap-3">

                                @foreach($this->rooms as $room)

                                    <label class="border rounded-lg p-3 flex justify-between cursor-pointer">

                                        <div>

                                            <p class="font-medium">
                                                Room {{ $room->room_number }}
                                            </p>

                                            <p class="text-sm text-gray-500">
                                                {{ $room->roomType->name }}
                                                • ₱{{ number_format($room->roomType->price) }}
                                            </p>

                                        </div>

                                        <input
                                            type="checkbox"
                                            wire:model.live="selectedRooms"
                                            value="{{ $room->id }}"
                                            class=""
                                        >

                                    </label>

                                @endforeach

                            </div>

                        @else

                            <p class="text-gray-400 text-sm">
                                Select room type and dates to see available rooms
                            </p>

                        @endif

                    </div>
                    
                    {{-- <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-gray-800 transition"
                        >
                            Add Booking
                        </button>
                    </div> --}}

                </div>

            </div>

            {{--  --}}
            <div class="col-span-2 bg-white text-slate-800 rounded-3xl shadow-sm border border-slate-200 p-6 md:p-7 w-full">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm text-slate-500">Payment Details</p>
                        <h2 class="text-2xl font-bold mt-1">Summary</h2>
                    </div>

                    <div class="h-11 w-11 rounded-2xl bg-slate-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5m-18 0A2.25 2.25 0 0 0 1.5 10.5v7.125A2.25 2.25 0 0 0 3.75 19.875h16.5A2.25 2.25 0 0 0 22.5 17.625V10.5a2.25 2.25 0 0 0-2.25-2.25m-16.5 0V6.375A2.25 2.25 0 0 1 6 4.125h12a2.25 2.25 0 0 1 2.25 2.25V8.25" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-4">


                    <div class="">

                        <h3 class="text-slate-500">
                            Selected Rooms
                        </h3>

                        @forelse($this->selectedRoomDetails as $room)

                            <div class="flex justify-between text-sm text-slate-500 mt-2">

                                <span>
                                    Room {{ $room->room_number }}
                                </span>

                                <span>
                                    ₱{{ number_format($room->roomType->price) }}
                                </span>

                            </div>

                        @empty

                            <p class="text-gray-400 text-sm">
                                No room selected
                            </p>

                        @endforelse

                    </div>
                    
                    <hr>
                    
                    {{-- <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Room Rate</span>
                        <span class="font-medium text-slate-800">₱3,500.00</span>
                    </div> --}}

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Number of Nights</span>
                        <span class="font-medium text-slate-800">{{ $this->nights }}</span>
                    </div>

                    

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Service Fee</span>
                        <span class="font-medium text-slate-800">₱{{ number_format($this->service_charge) }}</span>
                    </div>

                    {{-- <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Discount</span>
                        <span class="font-medium text-emerald-600">- ₱1,000.00</span>
                    </div> --}}

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Tax</span>
                        <span class="font-medium text-slate-800">₱{{ number_format($this->tax) }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Subtotal</span>
                        <span class="font-medium text-slate-800">₱{{ number_format($this->subtotal) }}</span>
                    </div>
                </div>

                <div class="my-6 border-t border-slate-200"></div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Amount</p>
                        <p class="text-3xl font-bold tracking-tight mt-1 text-slate-900">₱{{ number_format($this->total) }}</p>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                        Balance Due
                    </span>
                </div>

                <div class="mt-6 rounded-2xl bg-slate-50 border border-slate-200 p-4">
                    {{-- <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Amount Paid</span>
                        <span class="font-semibold text-slate-800">₱5,000.00</span>
                    </div> --}}
                    <div class=" flex items-center justify-between text-sm">
                        <span class="text-slate-500">Remaining Balance</span>
                        <span class="font-semibold text-amber-600">₱{{ number_format($this->total) }}</span>
                    </div>
                </div>

                <button type="submit" class="mt-6 w-full rounded-2xl bg-slate-900 text-white font-semibold py-3.5 hover:bg-slate-700 transition">
                    Add Booking
                </button>

                {{-- <button class="mt-3 w-full rounded-2xl border border-slate-300 text-slate-700 font-semibold py-3.5 hover:bg-slate-100 transition">
                    Print Summary
                </button> --}}

            </div>
            
        </section>
    </form>
</div>
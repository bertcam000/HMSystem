<?php

use Livewire\Volt\Component;

new class extends Component {

    public $room_number;
    public $floor;
    public $room_type_id;

    public function submit()
    {
        $this->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'room_type_id' => 'required',
            'floor' => 'required|integer',
        ]);

        \App\Models\Room::create([
            'room_number' => $this->room_number,
            'room_type_id' => $this->room_type_id,
            'floor' => $this->floor,
        ]);
    

        $this->reset(['room_number']);

        redirect('rooms')->with('success', 'Room added successfully!');
    }

    public function getRoomType(){
        return \App\Models\RoomType::get();
    }

    public function with(){
        return [
            'roomtypes' => $this->getRoomType(),
        ];
    }
    
}; ?>


<div @click.away="addRoom =false" class="max-w-md mx-auto mt-10 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Add New Room</h2>
    <p class="text-sm text-gray-500 mb-6">Enter the room number to add it to the system.</p>
    <form class="space-y-4" wire:submit.prevent="submit" @click.away="fmodal = ''">
        <div>
            <label class="block text-sm text-gray-600 mb-1" for="name">Room Number</label>
            <input
                wire:model="room_number"
                type="text"
                id="name"
                name="name"
                placeholder="e.g. 101, 102"
                class="uppercase-input w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-gray-200 focus:outline-none @error('name') border-red-500 @enderror"
            >
            <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1" for="name">Room Floor</label>
            <input
                wire:model="floor"
                type="text"
                id="name"
                name="name"
                placeholder="e.g. 1"
                class="uppercase-input w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-gray-200 focus:outline-none @error('floor') border-red-500 @enderror"
            >
            <x-input-error :messages="$errors->get('floor')" class="mt-2" />
        </div>
        <select wire:model="room_type_id" class="uppercase-input w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 @error('room_type_id') border-red-500 @enderror">
            <option value="">Select Room Type</option>
            @forelse ($roomtypes as $roomtype)
                <option value="{{ $roomtype->id }}">{{ $roomtype->name }}</option>
            @empty
                <option value="" disabled>No room type available.</option>
            @endforelse
        </select>
        <div class="flex justify-end">
            <button
                type="submit"
                class="px-5 py-2 text-sm font-medium bg-gray-900 text-white bg-black rounded-lg hover:bg-gray-800 transition"
            >
                Add Room
            </button>
        </div>

    </form>

</div>
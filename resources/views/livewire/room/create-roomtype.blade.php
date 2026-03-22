<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;

use App\Models\RoomType;
use App\Models\RoomTypeImage;
use App\Models\Feature;
use App\Models\Facility;

new class extends Component {

    use WithFileUploads;

    public $name;
    public $bed_type;
    public $price;
    public $capacity;
    public $description;

    public $images = [];

    public $features = [];
    public $facilities = [];

    public $allFeatures;
    public $allFacilities;

    public function mount()
    {
        $this->allFeatures = Feature::all() ?? [];
        $this->allFacilities = Facility::all() ?? [];
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'bed_type' => 'required|string',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png',
        ]);

        $roomType = RoomType::create([
            'name' => $this->name,
            'bed_type' => $this->bed_type,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'description' => $this->description
        ]);

        foreach ($this->images as $image) {

            $path = $image->store('room_types', 'public');

            RoomTypeImage::create([
                'room_type_id' => $roomType->id,
                'image_path' => $path
            ]);

        }

        $roomType->features()->attach($this->features);
        $roomType->facilities()->attach($this->facilities);

        $this->reset();

        // session()->flash('success', 'Room Type Created Successfully');
        return redirect('/room-type')->with('success', 'Asset created successfully!');
    }

};

?>

<div @click.away="open = false" class="max-h-[95vh] overflow-y-auto w-[650px] mx-auto bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">New Room Type</h2>
    <form class="space-y-4 mt-4" wire:submit.prevent="save" enctype="multipart/form-data">

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-input wire:model="name" icon="building-library" label="Room Type" placeholder="Deluxe"/>
            <x-input wire:model="bed_type" icon="clipboard" label="Bed Type" placeholder="Double"/>
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-number wire:model="capacity" label="Room capacity" placeholder="0" />
            <x-number wire:model="price" label="Room Price" placeholder="0" />
        </div>

         <!-- FEATURES -->
        <div>

            <h3 class="text-sm text-gray-600 font-medium mb-2">
                Features
            </h3>

            <div class="grid grid-cols-2 gap-2">

                @foreach($allFeatures as $feature)

                    <label class="flex items-center gap-2 text-sm">

                        <input
                            type="checkbox"
                            wire:model="features"
                            value="{{ $feature->id }}"
                        >

                        {{ $feature->name }}

                    </label>

                @endforeach

            </div>

        </div>

            <!-- FACILITIES -->
        <div>

            <h3 class="text-sm text-gray-600 font-medium mb-2">
                Facilities
            </h3>

            <div class="grid grid-cols-2 gap-2">

                @foreach($allFacilities as $facility)

                    <label class="flex items-center gap-2 text-sm">

                        <input
                            type="checkbox"
                            wire:model="facilities"
                            value="{{ $facility->id }}"
                        >

                        {{ $facility->name }}

                    </label>

                @endforeach

            </div>

        </div>
        
        {{-- <x-textarea wire:model="description" label="Notes" placeholder="write your notes" /> --}}


        <!-- IMAGE UPLOAD -->
        <div class="grid space-y-2">
            <label class="text-sm font-medium">Room Images</label>
            <input type="file" wire:model="images" multiple class="w-full border rounded-lg px-3 py-2 mt-1">
            <div wire:loading wire:target="images" class="text-sm text-gray-500 mt-1">Uploading images...</div>
        </div>
        
        <div class="flex justify-end">
            {{-- <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-gray-800 transition">Add Guest </button> --}}
            <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="images"
                        class="bg-primary text-white px-5 py-2 rounded-lg disabled:opacity-50"
                    >

                        <span wire:loading.remove wire:target="images">
                            Save Room Type
                        </span>

                        <span wire:loading wire:target="images">
                            Uploading...
                        </span>

                    </button>
        </div>

    </form>

</div>

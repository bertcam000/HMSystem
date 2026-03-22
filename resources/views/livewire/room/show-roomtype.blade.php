<?php

use App\Models\RoomType;
use Livewire\Volt\Component;

new class extends Component {

    public $roomType;

    public function mount($roomType)
    {
        $this->roomType = RoomType::with([
            'rooms',
            'images',
            'features',
            'facilities',
        ])->findOrFail($roomType);
    }
    
}; ?>

<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div class="relative w-full max-w-6xl rounded-3xl bg-white shadow-2xl overflow-hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <p class="text-sm text-slate-500">Room Type Details</p>
                <h2 class="text-2xl font-bold text-slate-800">{{ $roomType->name }}</h2>
            </div>

            <button @click="res = false" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 max-h-[85vh] overflow-y-auto">
            
            <!-- Left: Images -->
            <div class="bg-slate-50 p-6 border-r border-slate-200">
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($roomType->images as $image)
                        <img @click="open=true; image='{{ asset('storage/'.$image->image_path) }}'"
                        src="{{ asset('storage/'.$image->image_path) }}"
                        class="h-56 w-full rounded-2xl object-cover shadow-sm">
                    @endforeach
                    
                </div>

                <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-4">
                    <!-- Amenities -->
                    <div class="">
                        <p class="text-sm font-semibold text-slate-700 mb-3">Amenities</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($roomType->facilities as $facility)
                                <span class="rounded-full bg-slate-100 px-3 py-2 text-sm text-slate-700">{{ $facility->name }}</span>
                            @endforeach
                            @foreach ($roomType->features as $features)
                                <span class="rounded-full bg-slate-100 px-3 py-2 text-sm text-slate-700">{{ $features->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Full Details -->
            <div class="p-6 md:p-8">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Room Type</p>
                        <p class="mt-2 text-base font-semibold text-slate-800">{{ $roomType->name }}</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Base Price</p>
                        <p class="mt-2 text-base font-semibold text-slate-800">₱{{ $roomType->price }} / night</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Capacity</p>
                        <p class="mt-2 text-base font-semibold text-slate-800">{{ $roomType->capacity }}</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Bed Type</p>
                        <p class="mt-2 text-base font-semibold text-slate-800">{{ $roomType->bed_type }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6 rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm font-semibold text-slate-700">Description</p>
                    <p class="mt-2 text-sm leading-7 text-slate-600">
                        {{$roomType->description}}
                    </p>
                </div>

                

                <!-- Extra Details -->
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Rooms Assigned</p>
                        <p class="mt-2 text-lg font-bold text-slate-800">{{ count($roomType->rooms) }} Rooms</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Last Updated</p>
                        <p class="mt-2 text-lg font-bold text-slate-800">March 22, 2026</p>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button class="w-full sm:w-auto rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition">
                        Edit Room Type
                    </button>

                    <button class="w-full sm:w-auto rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

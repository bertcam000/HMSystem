<x-layouts.layout>
    @if (session('success'))
        <x-notification :message="session('success')" type="success" />
    @endif
    <section class="space-y-7  rounded-xl" x-data="{ open: false }">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 ">Room Management</h1>
                <p class="text-gray-600">6 total rooms</p>
            </div>
            <button @click="open = true" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryDark transition-colors text-sm font-medium">
            + Add Room
            </button>
        </div>

        
        <div class="bg-white border border-gray-400/50 rounded-lg lg:p-5 space-y-5">
            <div class="flex justify-between items-center">
                <div class="text-gray-500 text-xl">
                    RoomType List
                </div>
                <form action="/rooms" method="GET">
                    <div class="flex items-center gap-3">
                        <x-input name="name" value="{{ request('name') }}" icon="magnifying-glass" placeholder="Search something..."/>
                        <button type="submit" class="bg-primary py-2 px-3 rounded-md text-white">Search</button>
                    </div>
                </form>
            </div>
            <hr>
            
            {{-- <div class="grid lg:grid-cols-2 gap-5 justify-center items-center ">
                @forelse ($roomTypes as $roomType)
                <div x-data="{res: false, dl: false}" class="border border-gray-400/50 p-2 grid lg:flex lg:items-center gap-5 w-full">
                    <img src="{{ $roomType->images->first()
                        ? asset('storage/'.$roomType->images->first()->image_path)
                        : 'https://via.placeholder.com/300' }}" class="w-full lg:w-32 h-[250px] lg:h-28 object-cover rounded-lg" alt="">
                    <div class="flex-col flex justify-between w-full space-y-4">
                        <div class="flex justify-between gap-2">
                            <div>
                                <div class="font-semibold">{{ $roomType->name }}</div>
                                <p class="text-gray-500 text-sm">{{ Str::limit($roomType->description, 80) }}</p>
                            </div>
                            <div class="flex items-start gap-2 text-sm">
                                <button class="flex items-center gap-1 text-green-500"><x-icon class="w-4" name="pencil"/> edit</button>
                                <button @click="dl = true" class="flex items-center gap-1 text-red-500"><x-icon class="w-4" name="trash"/>delete</button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-gray-500">$500/night</p>
                            <button @click="res = true" class="bg-primary rounded-md text-white px-3 py-1">View</button>
                        </div>
                    </div>

                    <div x-show="res" x-cloak class="px-2 md:px-0 transition-all duration-300 flex h-screen w-full bg-black/20 fixed -top-0 left-0 z-50  justify-center items-center">
                        <livewire:room.show-roomtype :roomType="$roomType->id"/>
                    </div>

                    <div x-show="dl" x-cloak class="fixed inset-0 flex items-center justify-center z-50">
                        
                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="dl = false"></div>

                        <div class="bg-white rounded-lg shadow-lg w-96 p-6 z-50"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90">

                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Delete Confirmation</h2>
                            <p class="text-gray-600 mb-6">Are you sure? This Room Type and all room with this room type will permanently deleted</p>

                            <div class="flex justify-end gap-3">
                                <button @click="dl = false" 
                                        class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">
                                    Cancel
                                </button>

                                <form method="POST" action="/rooms/delete/{{ $roomType->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 rounded bg-red-500 hover:bg-red-600 text-white">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>

                
                
                @empty
                    
                @endforelse
            </div> --}}

            {{--  --}}
            <div class="mt-6 grid grid-cols-1 gap-5 xl:grid-cols-2">
                @forelse ($roomTypes as $roomType)
                    <div
                        x-data="{ dl: false, res: false }"
                        class="group rounded-[26px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                            <!-- Image -->
                            <div class="relative h-44 w-full shrink-0 overflow-hidden rounded-3xl sm:h-32 sm:w-40">
                                <img
                                    src="{{ $roomType->images->first()
                                        ? asset('storage/'.$roomType->images->first()->image_path)
                                        : 'https://via.placeholder.com/300' }}"
                                    alt="{{ $roomType->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                                <div class="absolute left-3 top-3">
                                    <span class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-700 backdrop-blur">
                                        {{ $roomType->capacity }} Guests
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-900">{{ $roomType->name }}</h3>
                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ Str::limit($roomType->description, 70) }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-3 text-sm">
                                        <a href="#" class="font-medium text-emerald-600 transition hover:text-emerald-700">
                                            Edit
                                        </a>

                                        <button
                                            type="button"
                                            @click="dl = true"
                                            class="font-medium text-rose-600 transition hover:text-rose-700"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap items-center gap-2">
                                    @foreach ($roomType->features as $feature)
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $feature->name }}</span>
                                    @endforeach
                                </div>

                                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Rate per night</p>
                                        <p class="mt-1 text-2xl font-bold text-slate-900">
                                            ₱{{ $roomType->price }}<span class="text-sm font-medium text-slate-500">/night</span>
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        @click="res = true"
                                        class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                                    >
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- View Modal -->
                        <template x-teleport="body">
                            <div
                                x-show="res"
                                x-cloak
                                class="fixed inset-0 z-[999] flex items-center justify-center p-4"
                            >
                                <div
                                    class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                    @click="res = false"
                                ></div>

                                <div
                                    @click.outside="res = false"
                                    class="relative z-10 max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-[28px]"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                >
                                    <livewire:room.show-roomtype :roomType="$roomType->id" />
                                </div>
                            </div>
                        </template>

                        <!-- Delete Modal -->
                        <template x-teleport="body">
                            <div
                                x-show="dl"
                                x-cloak
                                class="fixed inset-0 z-[999] flex items-center justify-center p-4"
                            >
                                <div
                                    class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                    @click="dl = false"
                                ></div>

                                <div
                                    @click.outside="dl = false"
                                    class="relative z-10 w-full max-w-md rounded-[28px] bg-white p-6 shadow-2xl"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                >
                                    <div class="flex items-start gap-4">
                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM10.29 3.86 1.82 18a2.25 2.25 0 0 0 1.93 3.375h16.5A2.25 2.25 0 0 0 22.18 18L13.71 3.86a2.25 2.25 0 0 0-3.42 0Z" />
                                            </svg>
                                        </div>

                                        <div>
                                            <h2 class="text-xl font-bold text-slate-900">Delete Room Type</h2>
                                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                                Are you sure you want to delete
                                                <span class="font-semibold text-slate-700">{{ $roomType->name }}</span>?
                                                This room type and all rooms using this room type may be affected.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                                        <button
                                            type="button"
                                            @click="dl = false"
                                            class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            Cancel
                                        </button>

                                        <form method="POST" action="/rooms/delete/{{ $roomType->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                @empty
                    <div class="col-span-full rounded-[26px] border border-dashed border-slate-300 bg-white p-10 text-center">
                        <h3 class="text-lg font-semibold text-slate-900">No room types found</h3>
                        <p class="mt-2 text-sm text-slate-500">Start by adding a new room type.</p>
                    </div>
                @endforelse
            </div>
            {{--  --}}
            
        </div>

        {{-- MODAl --}}
        <div x-show="open" x-cloak class="px-2 md:px-0 transition-all duration-300 flex h-screen w-full bg-black/20 fixed -top-7 left-0 z-50  justify-center items-center">
            <livewire:room.create-roomtype/>
        </div>
        
    </section>
</x-layouts.layout>
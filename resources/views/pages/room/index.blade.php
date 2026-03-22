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
            <div class="grid lg:grid-cols-2 gap-5 justify-center items-center ">
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

                    {{--  --}}
                    <div x-show="res" x-cloak class="px-2 md:px-0 transition-all duration-300 flex h-screen w-full bg-black/20 fixed -top-0 left-0 z-50  justify-center items-center">
                        <livewire:room.show-roomtype :roomType="$roomType->id"/>
                    </div>

                    {{-- delete --}}
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
            </div>
        </div>

        {{-- MODAl --}}
        <div x-show="open" x-cloak class="px-2 md:px-0 transition-all duration-300 flex h-screen w-full bg-black/20 fixed -top-7 left-0 z-50  justify-center items-center">
            <livewire:room.create-roomtype/>
        </div>
        
    </section>
</x-layouts.layout>
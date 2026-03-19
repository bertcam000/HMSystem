<x-layouts.layout>
    <section class="space-y-7  rounded-xl">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 ">Room Management</h1>
                <p class="text-gray-600">6 total rooms</p>
            </div>
            <button @click="addGuest = true" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryDark transition-colors text-sm font-medium">
            + Add Room
            </button>
        </div>

        <div class="flex justify-between">
            <x-input icon="magnifying-glass"/>
            <x-input />
        </div>
        <div class="flex flex-wrap gap-5 justify-center items-center bg-white border border-gray-400/50 rounded-lg lg:p-5">
            <div class="border border-gray-400/50 p-2 rounded-xl grid lg:flex gap-5 w-full lg:w-[750px]">
                <img src="https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg" class="w-full lg:w-52 h-[250px] lg:h-44 object-cover rounded-lg" alt="">
                <div class="flex-col flex justify-between w-full py-3 pr-5">
                    <div class="flex justify-between ">
                        <div>
                            <div>Family Room</div>
                            <p class="text-gray-500 text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                        </div>
                        <div>
                            <button>***</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>$500/night</div>
                        <button class="bg-primary rounded-md text-white px-3 py-1">View</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.layout>
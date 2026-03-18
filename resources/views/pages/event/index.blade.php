<x-layouts.layout>

    <div class="grid lg:grid-cols-7 h-screen">

        <!-- Sidebar -->
        <aside class="col-span-2 w-full  bg-white p-4 border-r">

            <!-- Mini Calendar -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <button>&lt;</button>
                    <h2 class="font-semibold">June 2028</h2>
                    <button>&gt;</button>
                </div>

                <div class="grid grid-cols-7 text-xs text-center gap-1 text-gray-500">
                    <span>Sun</span><span>Mon</span><span>Tue</span>
                    <span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>

                    <!-- Dummy days -->
                    <script>
                        for (let i = 1; i <= 30; i++) {
                            document.write(`<span class="p-1 hover:bg-gray-200 rounded">${i}</span>`)
                        }
                    </script>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <h3 class="font-semibold mb-2">Category</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-green-300 rounded-full"></span> Training
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-blue-300 rounded-full"></span> Meeting
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-yellow-300 rounded-full"></span> Guest Service
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-purple-300 rounded-full"></span> Maintenance
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-gray-300 rounded-full"></span> Event
                    </div>
                </div>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="col-span-5 flex-1 p-4 overflow-auto">

            <!-- Header -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4 gap-3">
                <h1 class="text-xl font-bold">Schedule</h1>

                <div class="flex gap-2 flex-wrap">
                    <button class="px-3 py-1 text-sm bg-gray-200 rounded">Day</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 rounded">Week</button>
                    <button class="px-3 py-1 text-sm bg-green-200 rounded">Month</button>
                    <button class="px-3 py-1 text-sm bg-gray-200 rounded">All Category</button>
                    <button class="px-3 py-1 text-sm bg-green-500 text-white rounded">+ Add Schedule</button>
                </div>
            </div>

            <div class="grid grid-cols-7 bg-gray-100 text-center text-sm font-semibold text-gray-500">
                <div class="p-2">Sun</div>
                <div class="p-2">Mon</div>
                <div class="p-2">Tue</div>
                <div class="p-2">Wed</div>
                <div class="p-2">Thu</div>
                <div class="p-2">Fri</div>
                <div class="p-2">Sat</div>
            </div>
            <!-- Calendar Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 border bg-white rounded-lg overflow-hidden">

                <!-- Day Cell -->
                <!-- Repeat this block for each day -->
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">1</span>

                    <!-- Event -->
                    <div class="mt-1 p-2 rounded bg-yellow-200 text-xs">
                        <p class="font-semibold">11:00 AM - 1:00 PM</p>
                        <p>Room Inspection</p>
                    </div>
                </div>

                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">5</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">2:00 PM - 4:00 PM</p>
                        <p>Fire Safety Training</p>
                    </div>
                </div>

                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">7</span>

                    <div class="mt-1 p-2 rounded bg-blue-200 text-xs">
                        <p class="font-semibold">1:00 PM</p>
                        <p>VIP Guest Arrival</p>
                    </div>
                </div>

                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">12</span>

                    <div class="mt-1 p-2 rounded bg-yellow-200 text-xs">
                        <p class="font-semibold">9:00 AM - 1:00 PM</p>
                        <p>Inventory Check</p>
                    </div>
                </div>

                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">15</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">11:00 AM</p>
                        <p>Housekeeping Training</p>
                    </div>
                </div>

                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">23</span>

                    <div class="mt-1 p-2 rounded bg-yellow-200 text-xs">
                        <p class="font-semibold">11:00 AM - 1:00 PM</p>
                        <p>Maintenance Check</p>
                    </div>
                </div>

                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>
                <div class="border p-2 h-40 flex flex-col">
                    <span class="text-xs text-gray-400">30</span>

                    <div class="mt-1 p-2 rounded bg-green-200 text-xs">
                        <p class="font-semibold">5:00 PM</p>
                        <p>End of Month Celebration</p>
                    </div>
                </div>

            </div>
        </main>

    </div>

</x-layouts.layout>
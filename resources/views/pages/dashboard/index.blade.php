<x-layouts.layout>
    <div class="p-4 space-y-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 ">Dashboard</h1>
                <p class="text-gray-600">Welcome to your dashboard! Here you can </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div class="flex gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div class="bg-green-100/80 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="key" class="w-5 h-5 text-green-900" outline />
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Available Rooms</div>
                    <p class="text-2xl font-bold">5</p>
                    <p class="text-gray-400 text-xs">4 occupied</p>
                </div>
            </div>
            <div class="flex gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div class="bg-blue-100/80 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="calendar-date-range" class="w-5 h-5 text-blue-900" outline />
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Today's Check-ins</div>
                    <p class="text-2xl font-bold">5</p>
                    <p class="text-gray-400 text-xs">confirmed bookings</p>
                </div>
            </div>
            <div class="flex gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div class="bg-yellow-100/80 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="arrow-trending-up" class="w-5 h-5 text-yellow-900" outline />
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Todays Check-outs</div>
                    <p class="text-2xl font-bold">5</p>
                    <p class="text-gray-400 text-xs">due today</p>
                </div>
            </div>
            <div class="flex gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div class="bg-violet-100/80 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="currency-dollar" class="w-5 h-5 text-violet-900" outline />
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Total Revenue</div>
                    <p class="text-2xl font-bold">₱ 1,250</p>
                    <p class="text-gray-400 text-xs">all bookings</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mt-4">
            <div class="col-span-4 space-y-5">
                <div class="bg-white border border-gray-300/60 rounded-xl p-5">
                    <div class="w-full text-center">STATUS</div>
                    <canvas class=" " id="myChart"></canvas>
                </div>
                <div class=" bg-white border border-gray-300/60 rounded-xl">
                    <div class="flex justify-between items-center px-7 py-4 border-b border-gray-300/60">
                        <div>Recent Bookings</div>
                        <button class="text-xs text-gray-500">View All</button>
                    </div>
                    {{-- data --}}
                    <div class="flex justify-between items-center px-7 py-3 border-b border-gray-300/60">
                        <div>
                            <div class="text-sm">name ng client</div>
                            <p class="text-gray-500 text-xs">Room 201 · 2026-03-18 → 2026-03-28</p>
                        </div>
                        <div>
                            <h1 class="text-sm">pending</h1>
                            <p class="font-xs text-gray-500">$1,290</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center px-7 py-3 border-b border-gray-300/60">
                        <div>
                            <div class="text-sm">name ng client</div>
                            <p class="text-gray-500 text-xs">Room 201 · 2026-03-18 → 2026-03-28</p>
                        </div>
                        <div>
                            <h1 class="text-sm">pending</h1>
                            <p class="font-xs text-gray-500">$1,290</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center px-7 py-3 border-b border-gray-300/60">
                        <div>
                            <div class="text-sm">name ng client</div>
                            <p class="text-gray-500 text-xs">Room 201 · 2026-03-18 → 2026-03-28</p>
                        </div>
                        <div>
                            <h1 class="text-sm">pending</h1>
                            <p class="font-xs text-gray-500">$1,290</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center px-7 py-3 border-b border-gray-300/60">
                        <div>
                            <div class="text-sm">name ng client</div>
                            <p class="text-gray-500 text-xs">Room 201 · 2026-03-18 → 2026-03-28</p>
                        </div>
                        <div>
                            <h1 class="text-sm">pending</h1>
                            <p class="font-xs text-gray-500">$1,290</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center px-7 py-3 border-b border-gray-300/60">
                        <div>
                            <div class="text-sm">name ng client</div>
                            <p class="text-gray-500 text-xs">Room 201 · 2026-03-18 → 2026-03-28</p>
                        </div>
                        <div>
                            <h1 class="text-sm">pending</h1>
                            <p class="font-xs text-gray-500">$1,290</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center px-7 py-3 border-b border-gray-300/60">
                        <div>
                            <div class="text-sm">name ng client</div>
                            <p class="text-gray-500 text-xs">Room 201 · 2026-03-18 → 2026-03-28</p>
                        </div>
                        <div>
                            <h1 class="text-sm">pending</h1>
                            <p class="font-xs text-gray-500">$1,290</p>
                        </div>
                    </div>
                    {{-- data --}}
                </div>
            </div>
            <div class="col-span-2 space-y-5">
                <div class=" p-5 bg-white border border-gray-300/60 rounded-xl">
                    <div>Room Status</div>
                    <div class="flex justify-between items-center mt-3">
                        <div class="text-gray-700 text-sm"> <span class="bg-green-500 w-2 h-2 rounded-full inline-block mr-2"></span> Available</div>
                        <div class="font-bold">5</div>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <div class="text-gray-700 text-sm"> <span class="bg-blue-500 w-2 h-2 rounded-full inline-block mr-2"></span> Available</div>
                        <div class="font-bold">5</div>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <div class="text-gray-700 text-sm"> <span class="bg-purple-500 w-2 h-2 rounded-full inline-block mr-2"></span> Available</div>
                        <div class="font-bold">5</div>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <div class="text-gray-700 text-sm"> <span class="bg-orange-500 w-2 h-2 rounded-full inline-block mr-2"></span> Available</div>
                        <div class="font-bold">5</div>
                    </div>
                    <hr class="mt-4">
                    <div class="flex justify-between items-center">
                        <h1 class="text-sm text-gray-500 mt-2">Total Rooms</h1>
                        <p class="font-bold">10</p>
                    </div>
                </div>
                {{-- chart --}}
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <div class="bg-white border border-gray-300/60 rounded-xl p-5">
                    <div class="w-full text-center">STATUS</div>
                    <canvas class=" " id="myChart2"></canvas>
                </div>
                {{-- chart --}}
            </div>
        </div>
    </div>
<script>
    const ctx = document.getElementById('myChart');
      
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June'],
          datasets: [{
            label: 'Sample',
            data: [12, 19, 6, 5, 8, 10],
            backgroundColor:[
              'rgba(255, 99, 132)',
              'rgba(54, 162, 235)',
              'rgba(255, 159, 64)',
                'rgba(255, 205, 86)',
                'rgba(75, 192, 192)',
                'rgba(153, 102, 255)'
          ],
            borderWidth: 1
          }]
        },
        options: {
          aspectRatio: 2,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
    });

    const ctx2 = document.getElementById('myChart2');
      
      new Chart(ctx2, {
        type: 'pie',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June'],
          datasets: [{
            label: 'Sample',
            data: [12, 19, 6, 5, 8, 10],
            backgroundColor:[
              'rgba(255, 99, 132)',
              'rgba(54, 162, 235)',
              'rgba(255, 159, 64)',
                'rgba(255, 205, 86)',
                'rgba(75, 192, 192)',
                'rgba(153, 102, 255)'
          ],
            borderWidth: 1
          }]
        },
        options: {
          aspectRatio: 2,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
    });
</script>
</x-layouts.layout>
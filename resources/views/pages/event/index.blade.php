<x-layouts.layout>

    <section class="min-h-screen bg-slate-50 p-4 sm:p-6">
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
        <!-- Left Sidebar -->
        <aside class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
            <!-- Mini Calendar Header -->
            <div class="mb-5 flex items-center justify-between">
                <button class="flex h-10 w-10 items-center justify-center rounded-2xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7" />
                    </svg>
                </button>

                <h2 class="text-lg font-bold tracking-tight text-slate-900">June 2028</h2>

                <button class="flex h-10 w-10 items-center justify-center rounded-2xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Mini Calendar -->
            <div class="rounded-[24px] bg-slate-50 p-4">
                <div class="grid grid-cols-7 gap-y-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-400">
                    <span>Sun</span>
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                    <span>Sat</span>
                </div>

                <div class="mt-4 grid grid-cols-7 gap-y-3 text-center text-sm text-slate-600">
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">1</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">2</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">3</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">4</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">5</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">6</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">7</span>

                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">8</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">9</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">10</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">11</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">12</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">13</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">14</span>

                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500 font-semibold text-white shadow-sm">15</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">16</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">17</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">18</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">19</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">20</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">21</span>

                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">22</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">23</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">24</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">25</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">26</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">27</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">28</span>

                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">29</span>
                    <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full">30</span>
                </div>
            </div>

            <!-- Categories -->
            <div class="mt-8">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900">Categories</h3>
                    <button class="text-sm font-medium text-emerald-600 transition hover:text-emerald-700">Manage</button>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 rounded-2xl px-3 py-2 transition hover:bg-slate-50">
                        <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                        <span class="text-sm font-medium text-slate-700">Training</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-2xl px-3 py-2 transition hover:bg-slate-50">
                        <span class="h-3 w-3 rounded-full bg-sky-400"></span>
                        <span class="text-sm font-medium text-slate-700">Meeting</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-2xl px-3 py-2 transition hover:bg-slate-50">
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                        <span class="text-sm font-medium text-slate-700">Guest Service</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-2xl px-3 py-2 transition hover:bg-slate-50">
                        <span class="h-3 w-3 rounded-full bg-violet-400"></span>
                        <span class="text-sm font-medium text-slate-700">Maintenance</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-2xl px-3 py-2 transition hover:bg-slate-50">
                        <span class="h-3 w-3 rounded-full bg-slate-300"></span>
                        <span class="text-sm font-medium text-slate-700">Event</span>
                    </label>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <!-- Header -->
            <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Schedule</h1>
                    <p class="mt-1 text-sm text-slate-500">Track events, operations, and hotel activities in one clean view.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end">
                    <div class="inline-flex rounded-2xl bg-slate-100 p-1">
                        <button class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-500 transition hover:text-slate-900">Day</button>
                        <button class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-500 transition hover:text-slate-900">Week</button>
                        <button class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-emerald-600 shadow-sm">Month</button>
                    </div>

                    <button class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        All Category
                    </button>

                    <button class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                        + Add Schedule
                    </button>
                </div>
            </div>

            <!-- Calendar Header -->
            <div class="mt-6 overflow-hidden rounded-[24px] border border-slate-200">
                <div class="grid grid-cols-7 bg-slate-50">
                    <div class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-500">Sun</div>
                    <div class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-500">Mon</div>
                    <div class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-500">Tue</div>
                    <div class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-500">Wed</div>
                    <div class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-500">Thu</div>
                    <div class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-500">Fri</div>
                    <div class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-500">Sat</div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7">
                    <!-- Day Cell -->
                    <div class="min-h-[170px] border-b border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">1</p>
                        <div class="mt-3 rounded-2xl bg-amber-100 p-3">
                            <p class="text-xs font-bold text-slate-900">11:00 AM - 1:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">Room Inspection</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-b border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">5</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">2:00 PM - 4:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">Fire Safety Training</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-b border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">7</p>
                        <div class="mt-3 rounded-2xl bg-sky-100 p-3">
                            <p class="text-xs font-bold text-slate-900">1:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">VIP Guest Arrival</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-b border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">12</p>
                        <div class="mt-3 rounded-2xl bg-amber-100 p-3">
                            <p class="text-xs font-bold text-slate-900">9:00 AM - 1:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">Inventory Check</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-b border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">15</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">11:00 AM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">Housekeeping Training</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-b border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">23</p>
                        <div class="mt-3 rounded-2xl bg-amber-100 p-3">
                            <p class="text-xs font-bold text-slate-900">11:00 AM - 1:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">Maintenance Check</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <!-- Additional Empty / Filled Cells -->
                    <div class="min-h-[170px] border-r border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-b border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-slate-200 bg-white p-3">
                        <p class="text-sm font-semibold text-slate-400">30</p>
                        <div class="mt-3 rounded-2xl bg-emerald-100 p-3">
                            <p class="text-xs font-bold text-slate-900">5:00 PM</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">End of Month Celebration</p>
                        </div>
                    </div>

                    <div class="min-h-[170px] border-r border-slate-200 bg-white p-3"></div>
                    <div class="min-h-[170px] border-r border-slate-200 bg-white p-3"></div>
                    <div class="min-h-[170px] border-r border-slate-200 bg-white p-3"></div>
                    <div class="min-h-[170px] bg-white p-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>

</x-layouts.layout>
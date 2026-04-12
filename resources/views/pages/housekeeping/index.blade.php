<x-layouts.layout>
    <div
        x-data="{
            assignModalOpen: false,
            updateModalOpen: false,

            selectedRoomId: '',
            selectedRoomNumber: '',

            selectedTaskId: '',
            selectedTaskStatus: '',
            selectedRoomStatus: '',

            openAssignModal(roomId, roomNumber) {
                this.selectedRoomId = roomId;
                this.selectedRoomNumber = roomNumber;
                this.assignModalOpen = true;
            },

            openUpdateModal(taskId, taskStatus) {
                this.selectedTaskId = taskId;
                this.selectedTaskStatus = taskStatus;
                this.selectedRoomStatus = '';
                this.updateModalOpen = true;
            }
        }"
        class="min-h-screen"
    >
        <div class="">

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Housekeeping
                </h1>
                <p class="mt-1 text-sm text-slate-500 sm:text-base">
                    Room cleaning and maintenance management
                </p>
            </div>

            <!-- Summary Cards -->
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-[24px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Needs Cleaning</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">{{ $needsCleaningCount }}</h3>
                </div>

                <div class="rounded-[24px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Active Tasks</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-blue-600">{{ $activeTasksCount }}</h3>
                </div>

                <div class="rounded-[24px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Completed</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">{{ $completedTasksCount }}</h3>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

                <!-- Rooms Needing Attention -->
                <div class="xl:col-span-6 rounded-[24px] border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Rooms Needing Attention</h2>

                    <div class="mt-5 space-y-3">
                        @forelse($roomsNeedingAttention as $room)
                            @php
                                $status = strtolower($room->status);
                            @endphp

                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">
                                            Room {{ $room->room_number }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $room->roomType->name ?? 'Room Type' }} • Floor {{ $room->floor }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        @if($status === 'dirty')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                                Dirty
                                            </span>
                                        @elseif($status === 'cleaning')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                                Cleaning
                                            </span>
                                        @elseif($status === 'maintenance')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                                <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                                Maintenance
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                                {{ $room->status }}
                                            </span>
                                        @endif

                                        <button
                                            type="button"
                                            @click="openAssignModal('{{ $room->id }}', '{{ $room->room_number }}')"
                                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            Assign
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
                                <p class="text-sm text-slate-500">No rooms currently need attention.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Housekeeping Tasks -->
                <div class="xl:col-span-6 rounded-[24px] border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Housekeeping Tasks</h2>

                    <div class="mt-5 space-y-3">
                        @forelse($tasks as $task)
                            @php
                                $taskStatus = strtolower($task->status);
                                $priority = strtolower($task->priority);
                            @endphp

                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-slate-900">
                                                Room {{ $task->room->room_number }}
                                            </p>

                                            @if($taskStatus === 'completed')
                                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                                    completed
                                                </span>
                                            @elseif($taskStatus === 'in_progress')
                                                <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-semibold text-blue-700">
                                                    in progress
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-700">
                                                    pending
                                                </span>
                                            @endif

                                            @if($priority === 'high')
                                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-700">
                                                    high
                                                </span>
                                            @elseif($priority === 'normal')
                                                <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-semibold text-blue-700">
                                                    normal
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">
                                                    low
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-1 text-xs text-slate-500">
                                            Assigned to: {{ $task->assigned_to ?: '—' }}
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        @click="openUpdateModal('{{ $task->id }}', '{{ $task->status }}')"
                                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
                                <p class="text-sm text-slate-500">No housekeeping tasks found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Assign Modal -->
        <div
            x-show="assignModalOpen"
            x-cloak
            class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/60 p-4"
        >
            <div @click.away="assignModalOpen = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">
                            Assign Housekeeping Task — Room <span x-text="selectedRoomNumber"></span>
                        </h3>
                    </div>

                    <button type="button" @click="assignModalOpen = false" class="text-slate-400 transition hover:text-slate-700">
                        ✕
                    </button>
                </div>

                <form action="{{ route('housekeeping.tasks.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <input type="hidden" name="room_id" :value="selectedRoomId">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Assigned To</label>
                        <input
                            type="text"
                            name="assigned_to"
                            placeholder="Staff name"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Priority</label>
                        <select
                            name="priority"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="low">Low</option>
                            <option value="normal" selected>Normal</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Notes</label>
                        <input
                            type="text"
                            name="notes"
                            placeholder="Condition notes..."
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button
                            type="button"
                            @click="assignModalOpen = false"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            Assign Task
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Modal -->
        <div
            x-show="updateModalOpen"
            x-cloak
            class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/60 p-4"
        >
            <div @click.away="updateModalOpen = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">
                            Update Task Status
                        </h3>
                    </div>

                    <button type="button" @click="updateModalOpen = false" class="text-slate-400 transition hover:text-slate-700">
                        ✕
                    </button>
                </div>

                <form :action="`/housekeeping/tasks/${selectedTaskId}`" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Task Status</label>
                        <select
                            name="status"
                            x-model="selectedTaskStatus"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <div x-show="selectedTaskStatus === 'completed'" x-cloak>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Update Room Status To</label>
                        <select
                            name="room_status"
                            x-model="selectedRoomStatus"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="">Select new room status</option>
                            <option value="Available">Available</option>
                            <option value="Dirty">Dirty</option>
                            <option value="Cleaning">Cleaning</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button
                            type="button"
                            @click="updateModalOpen = false"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
</x-layouts.layout>
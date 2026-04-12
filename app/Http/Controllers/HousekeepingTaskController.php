<?php

namespace App\Http\Controllers;

use App\Models\HousekeepingTask;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HousekeepingTaskController extends Controller
{
    public function index()
    {
        $roomsNeedingAttention = Room::with('roomType')
            ->whereIn('status', ['Dirty', 'Cleaning', 'Maintenance'])
            ->orderBy('room_number')
            ->get();

        $tasks = HousekeepingTask::with('room.roomType')
            ->latest()
            ->get();

        $needsCleaningCount = Room::where('status', 'Dirty')->count();

        $activeTasksCount = HousekeepingTask::whereIn('status', ['pending', 'in_progress'])->count();

        $completedTasksCount = HousekeepingTask::where('status', 'completed')->count();

        return view('pages.housekeeping.index', compact(
            'roomsNeedingAttention',
            'tasks',
            'needsCleaningCount',
            'activeTasksCount',
            'completedTasksCount'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'assigned_to' => ['required', 'string', 'max:255'],
            'priority' => ['required', Rule::in(['low', 'normal', 'high'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $room = Room::findOrFail($validated['room_id']);

        $hasActiveTask = HousekeepingTask::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->exists();

        if ($hasActiveTask) {
            return redirect()->back()->with('error', 'This room already has an active housekeeping task.');
        }

        HousekeepingTask::create([
            'room_id' => $room->id,
            'assigned_to' => $validated['assigned_to'],
            'priority' => $validated['priority'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Housekeeping task assigned successfully.');
    }

    public function update(Request $request, HousekeepingTask $task)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
            'room_status' => ['nullable', Rule::in(['Available', 'Dirty', 'Cleaning', 'Maintenance'])],
        ]);

        $taskStatus = $validated['status'];
        $roomStatus = $validated['room_status'] ?? null;

        $updateData = [
            'status' => $taskStatus,
        ];

        if ($taskStatus === 'in_progress' && !$task->started_at) {
            $updateData['started_at'] = now();
        }

        if ($taskStatus === 'completed') {
            $updateData['completed_at'] = now();
        }

        $task->update($updateData);

        if ($taskStatus === 'in_progress') {
            $task->room->update([
                'status' => 'Cleaning',
            ]);
        }

        if ($taskStatus === 'completed' && $roomStatus) {
            $task->room->update([
                'status' => $roomStatus,
            ]);
        }

        return redirect()->back()->with('success', 'Housekeeping task updated successfully.');
    }
}
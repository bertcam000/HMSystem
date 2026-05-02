<?php

namespace App\Http\Controllers;

use App\Models\RfidCard;
use Illuminate\Http\Request;

class RfidCardController extends Controller
{
    public function index(Request $request)
    {
        $rfidCards = RfidCard::query()
            ->with('activeBooking.guest')
            ->when($request->search, function ($query) use ($request) {
                $query->where('uid', 'like', '%' . $request->search . '%')
                    ->orWhere('remarks', 'like', '%' . $request->search . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => RfidCard::count(),
            'available' => RfidCard::where('status', 'available')->count(),
            'assigned' => RfidCard::where('status', 'assigned')->count(),
            'lost' => RfidCard::where('status', 'lost')->count(),
            'damaged' => RfidCard::where('status', 'damaged')->count(),
        ];

        return view('pages.rfid-cards.index', compact('rfidCards', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'uid' => ['required', 'string', 'max:255', 'unique:rfid_cards,uid'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        RfidCard::create([
            'uid' => trim($validated['uid']),
            'status' => 'available',
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return back()->with('success', 'RFID card registered successfully.');
    }

    public function update(Request $request, RfidCard $rfidCard)
    {
        $validated = $request->validate([
            'uid' => ['required', 'string', 'max:255', 'unique:rfid_cards,uid,' . $rfidCard->id],
            'status' => ['required', 'in:available,assigned,lost,damaged'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        if ($rfidCard->status === 'assigned' && $validated['status'] === 'available') {
            $hasActiveBooking = $rfidCard->activeBooking()->exists();

            if ($hasActiveBooking) {
                return back()->withErrors([
                    'status' => 'Cannot set this RFID to available because it is currently assigned to an active booking.',
                ]);
            }
        }

        $rfidCard->update([
            'uid' => trim($validated['uid']),
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return back()->with('success', 'RFID card updated successfully.');
    }

    public function destroy(RfidCard $rfidCard)
    {
        if ($rfidCard->status === 'assigned' || $rfidCard->activeBooking()->exists()) {
            return back()->withErrors([
                'delete' => 'Cannot delete an RFID card that is currently assigned.',
            ]);
        }

        $rfidCard->delete();

        return back()->with('success', 'RFID card deleted successfully.');
    }
}
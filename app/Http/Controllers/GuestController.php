<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guest::query()->with('bookings');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhereRaw("first_name || ' ' || last_name LIKE ?", ["%{$search}%"]);
            });
        }
       

        $guests = $query->latest()->paginate($pages = $request->pages ?: 10)->withQueryString();


        return view('pages.guest.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guest $guest)
    {
        $guest->load([
            'bookings' => fn ($query) => $query->latest('check_out_date')->take(3)
        ]);
        

        $lastBooking = $guest->lastBooking?->check_out_date 
            ? \Carbon\Carbon::parse($guest->lastBooking->check_out_date)->format('M d, Y') 
            : 'No stay yet';

        return view('pages.guest.edit', compact('guest', 'lastBooking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'nullable|email|max:255|unique:guests,email,' . $guest->id,
            'phone'         => 'nullable|string|max:50',
            'nationality'   => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'id_type'       => 'nullable|string|max:100',
            'id_number'     => 'nullable|string|max:100',
            'address'       => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ]);

        $guest->update($validated);

        return redirect('/guests')
            ->with('success', 'Guest updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect('/guests')
            ->with('success', 'Asset deleted successfully.');
    }
}

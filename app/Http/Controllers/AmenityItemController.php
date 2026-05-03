<?php

namespace App\Http\Controllers;

use App\Models\AmenityItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AmenityItemController extends Controller
{
    public function index(Request $request)
    {
        $items = AmenityItem::query()
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when($request->category, fn ($query) => $query->where('category', $request->category))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.amenity-items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['amenity', 'consumable', 'service', 'other'])],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'is_chargeable' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        AmenityItem::create([
            ...$validated,
            'is_chargeable' => $request->boolean('is_chargeable'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Amenity item created successfully.');
    }

    public function update(Request $request, AmenityItem $amenityItem)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['amenity', 'consumable', 'service', 'other'])],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'is_chargeable' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $amenityItem->update([
            ...$validated,
            'is_chargeable' => $request->boolean('is_chargeable'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Amenity item updated successfully.');
    }

    public function destroy(AmenityItem $amenityItem)
    {
        $amenityItem->delete();

        return back()->with('success', 'Amenity item deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['guest', 'rooms.roomType'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhereHas('guest', function ($guestQuery) use ($search) {
                        $guestQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                    });
            });
        }

        if ($request->filled('status')) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
        }

        if ($request->filled('payment_status')) {
            $query->whereRaw('LOWER(payment_status) = ?', [strtolower($request->payment_status)]);
        }

        $bookings = $query->paginate(10)->withQueryString();

        $totalInvoices = Booking::count();
        $paidInvoices = Booking::whereRaw('LOWER(payment_status) = ?', ['paid'])->count();
        $partialInvoices = Booking::whereRaw('LOWER(payment_status) = ?', ['partial'])->count();
        $unpaidInvoices = Booking::whereRaw('LOWER(payment_status) = ?', ['unpaid'])->count();

        return view('pages.invoices.index', compact(
            'bookings',
            'totalInvoices',
            'paidInvoices',
            'partialInvoices',
            'unpaidInvoices'
        ));
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'guest',
            'rooms.roomType',
            'payments',
            // 'charges',
        ]);

        return view('pages.invoices.show', compact('booking'));
    }

    
}
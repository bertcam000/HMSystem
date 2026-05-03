<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckInController extends Controller
{
    public function show(Booking $booking)
    {
        $booking->load(['guest', 'rooms.roomType', 'payments']);

        $nights = Carbon::parse($booking->check_in_date)
            ->diffInDays(Carbon::parse($booking->check_out_date));
        
        return view('pages.check-in.index', compact('booking', 'nights'));
    }


    public function store(Request $request, Booking $booking)
    {
        $booking->load(['payments', 'rooms']);

        // Compute real current balance:
        // Room total + active folio charges - payments
        $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
        $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

        $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
        $currentBalance = round($grandTotal - $paidAmount, 2);

        if ($currentBalance < 0.01) {
            $currentBalance = 0.00;
        }

        $rules = [
            'type' => ['nullable', Rule::in(['deposit', 'additional', 'full_payment', 'remaining_balance'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'gcash', 'bank_transfer', 'card'])],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];

        if ($currentBalance > 0) {
            $rules['amount'] = [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $currentBalance,
            ];

            $rules['type'][0] = 'required';
            $rules['payment_method'][0] = 'required';
        } else {
            $rules['amount'] = [
                'nullable',
                'numeric',
                'min:0',
            ];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $booking) {
            $booking->refresh();
            $booking->load(['payments', 'rooms']);

            $paymentAmount = round((float) ($validated['amount'] ?? 0), 2);

            if ($paymentAmount > 0) {
                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $paymentAmount,
                    'payment_method' => $validated['payment_method'],
                    'type' => $validated['type'],
                    'reference_number' => $validated['reference_number'] ?? null,
                    'notes' => $validated['notes'] ?? null,
                    'payment_date' => now(),
                ]);
            }

            $booking->refresh();
            $booking->load(['payments', 'rooms']);

            // Recompute after saving payment
            $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
            $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

            $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
            $balance = round($grandTotal - $paidAmount, 2);

            if ($balance < 0.01) {
                $balance = 0.00;
            }

            $paymentStatus = 'unpaid';

            if ($paidAmount > 0 && $paidAmount < $grandTotal) {
                $paymentStatus = 'partial';
            } elseif ($paidAmount >= $grandTotal) {
                $paymentStatus = 'paid';
            }

            $bookingStatus = $booking->status;
            $checkedInAt = $booking->checked_in_at;

            // FULL PAYMENT REQUIRED BEFORE CHECK-IN
            if (
                in_array(strtolower($booking->status), ['reserved', 'confirmed']) &&
                $balance <= 0
            ) {
                if ($booking->rooms->isEmpty()) {
                    abort(422, 'This booking has no assigned room.');
                }

                foreach ($booking->rooms as $room) {
                    if (strtolower($room->status) !== 'available') {
                        abort(422, 'One or more assigned rooms are not available for check-in.');
                    }
                }

                $bookingStatus = 'checked_in';
                $checkedInAt = now();

                foreach ($booking->rooms as $room) {
                    $room->update([
                        'status' => 'Occupied',
                    ]);
                }
            }

            $booking->update([
                'paid_amount' => $paidAmount,
                'balance' => $balance,
                'payment_status' => $paymentStatus,
                'status' => $bookingStatus,
                'checked_in_at' => $checkedInAt,
            ]);
        });

        return redirect('/booking/result/' . $booking->id)
            ->with('success', 'Check-in completed successfully.');
    }
    
    
}
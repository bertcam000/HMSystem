<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutPageController extends Controller
{
    public function index(Request $request)
    {
        $roomType = null;

        if ($request->filled('room_type')) {
            $roomType = RoomType::with('images')->find($request->room_type);
        }

        return view('public.checkout', compact('roomType'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'room_type_id'    => ['required', 'exists:room_types,id'],
            'check_in_date'   => ['required', 'date'],
            'check_out_date'  => ['required', 'date', 'after:check_in_date'],
            'adults'          => ['required', 'integer', 'min:1'],
            'children'        => ['nullable', 'integer', 'min:0'],
            'rooms'           => ['required', 'integer', 'min:1'],

            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'nationality'     => ['required', 'string', 'max:255'],
            // 'purpose'         => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'date_of_birth' => ['required', 'date'],
            'email'           => ['required', 'email', 'max:255'],
            'phone'           => ['required', 'string', 'max:255'],
            'id_type'         => ['nullable', 'string', 'max:255'],
            'id_number'       => ['required', 'string', 'max:255'],
            'requests'        => ['nullable', 'string'],

            'payment_method'  => ['required', 'string', 'max:255'],
            'promo_code'      => ['nullable', 'string', 'max:255'],
            'estimated_total' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $requiredRooms = (int) $validated['rooms'];

            $availableRooms = Room::where('room_type_id', $validated['room_type_id'])
                ->where('status', 'Available')
                ->get()
                ->filter(function ($room) use ($validated) {
                    return !Booking::whereIn('status', ['pending', 'confirmed', 'checked_in'])
                        ->whereHas('rooms', function ($query) use ($room) {
                            $query->where('rooms.id', $room->id);
                        })
                        ->where(function ($query) use ($validated) {
                            $query->where('check_in_date', '<', $validated['check_out_date'])
                                  ->where('check_out_date', '>', $validated['check_in_date']);
                        })
                        ->exists();
                })
                ->values();

            if ($availableRooms->count() < $requiredRooms) {
                DB::rollBack();

                return response()->json([
                    'message' => 'Not enough available rooms for the selected stay.',
                ], 422);
            }

            $assignedRooms = $availableRooms->take($requiredRooms);

            $guest = Guest::create([
                'first_name'  => $validated['first_name'],
                'last_name'   => $validated['last_name'],
                'email'       => $validated['email'],
                'phone'       => $validated['phone'],
                'address'     => $validated['address'],
                'date_of_birth' => $validated['date_of_birth'],
                'nationality' => $validated['nationality'],
                'id_type'     => $validated['id_type'] ?? 'Passport',
                'id_number'   => $validated['id_number'],
                'notes'       => $validated['requests'] ?? null,
            ]);

            $subtotal = (float) ($validated['estimated_total'] ?? 0);
            $tax = 0;
            $serviceCharge = 0;
            $totalPrice = $subtotal;
            $paidAmount = 0;
            $balance = $totalPrice;

            $booking = Booking::create([
                'booking_code'   => $this->generateBookingCode(),
                'guest_id'       => $guest->id,
                'source'         => 'website',
                'childen'        => (string) ($validated['children'] ?? 0),
                'adult'          => (string) $validated['adults'],
                'check_in_date'  => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'tax'            => $tax,
                'service_charge' => $serviceCharge,
                'subtotal'       => $subtotal,
                'total_price'    => $totalPrice,
                'paid_amount'    => $paidAmount,
                'balance'        => $balance,
                'payment_status' => 'unpaid',
                'status'         => 'pending',
            ]);

            foreach ($assignedRooms as $room) {
                $booking->rooms()->attach($room->id, [
                    'total_price' => $totalPrice / max($requiredRooms, 1),
                ]);
            }

            DB::commit();

            return response()->json([
                'message'      => 'Reservation submitted successfully.',
                'booking_id'   => $booking->id,
                'booking_code' => $booking->booking_code,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    protected function generateBookingCode(): string
    {
        do {
            $code = 'RES-' . str_pad((string) random_int(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}
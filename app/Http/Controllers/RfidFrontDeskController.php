<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RfidCard;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RfidFrontDeskController extends Controller
{
    public function index()
    {
        $bookings = Booking::query()
            ->with(['guest', 'rooms'])
            ->whereIn('status', ['reserved', 'confirmed'])
            ->latest()
            ->get();

        return view('pages.rfid-front-desk.index', [
            'bookings' => $bookings,
            'rfidUid' => null,
            'rfidCard' => null,
            'detectedBooking' => null,
            'mode' => null,
        ]);
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'rfid_uid' => ['required', 'string', 'max:255'],
        ]);

        $rfidUid = trim($validated['rfid_uid']);

        $rfidCard = RfidCard::where('uid', $rfidUid)->first();

        if (! $rfidCard) {
            return redirect()
                ->route('rfid.front-desk.index')
                ->withErrors([
                    'rfid_uid' => 'RFID card is not registered.',
                ]);
        }

        $bookings = Booking::query()
            ->with(['guest', 'rooms'])
            ->whereIn('status', ['reserved', 'confirmed'])
            ->latest()
            ->get();

        $detectedBooking = null;
        $mode = null;

        if (strtolower($rfidCard->status) === 'available') {
            $mode = 'check_in';
        }

        if (strtolower($rfidCard->status) === 'assigned') {
            $detectedBooking = Booking::query()
                ->with(['guest', 'rooms', 'payments', 'rfidCard'])
                ->where('rfid_card_id', $rfidCard->id)
                ->where('status', 'checked_in')
                ->latest()
                ->first();

            if (! $detectedBooking) {
                return redirect()
                    ->route('rfid.front-desk.index')
                    ->withErrors([
                        'rfid_uid' => 'RFID card is assigned but no active checked-in booking was found.',
                    ]);
            }

            $mode = 'check_out';
        }

        if (! in_array(strtolower($rfidCard->status), ['available', 'assigned'])) {
            return redirect()
                ->route('rfid.front-desk.index')
                ->withErrors([
                    'rfid_uid' => 'This RFID card is not available for check-in or check-out.',
                ]);
        }

        return view('pages.rfid-front-desk.index', [
            'bookings' => $bookings,
            'rfidUid' => $rfidUid,
            'rfidCard' => $rfidCard,
            'detectedBooking' => $detectedBooking,
            'mode' => $mode,
        ]);
    }

    public function checkIn(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'rfid_uid' => ['required', 'string', 'max:255'],
        ]);

        $uid = trim($validated['rfid_uid']);

        $rfidCard = RfidCard::where('uid', $uid)->first();

        if (! $rfidCard) {
            return back()->withErrors([
                'rfid_uid' => 'RFID card is not registered.',
            ]);
        }

        if (strtolower($rfidCard->status) !== 'available') {
            return back()->withErrors([
                'rfid_uid' => 'This RFID card is not available.',
            ]);
        }

        $booking->load(['rooms', 'payments']);

        if (! in_array(strtolower($booking->status), ['reserved', 'confirmed'])) {
            return back()->withErrors([
                'booking_id' => 'Only reserved or confirmed bookings can be checked in.',
            ]);
        }

        if ($booking->rfid_card_id) {
            return back()->withErrors([
                'booking_id' => 'This booking already has an assigned RFID card.',
            ]);
        }

        $balance = $this->computeBalance($booking);

        if ($balance > 0) {
            return back()->withErrors([
                'booking_id' => 'Guest must be fully paid before RFID check-in. Remaining balance: ₱' . number_format($balance, 2),
            ]);
        }

        if ($booking->rooms->isEmpty()) {
            return back()->withErrors([
                'booking_id' => 'This booking has no assigned room.',
            ]);
        }

        foreach ($booking->rooms as $room) {
            if (strtolower($room->status) !== 'available') {
                return back()->withErrors([
                    'booking_id' => 'One or more assigned rooms are not available for check-in.',
                ]);
            }
        }

        DB::transaction(function () use ($booking, $rfidCard) {
            $booking = Booking::lockForUpdate()->findOrFail($booking->id);
            $booking->load(['rooms', 'payments']);

            $lockedCard = RfidCard::lockForUpdate()->findOrFail($rfidCard->id);

            if (strtolower($lockedCard->status) !== 'available') {
                abort(422, 'This RFID card is no longer available.');
            }

            if (! in_array(strtolower($booking->status), ['reserved', 'confirmed'])) {
                abort(422, 'This booking is no longer eligible for check-in.');
            }

            $balance = $this->computeBalance($booking);

            if ($balance > 0) {
                abort(422, 'Guest still has remaining balance of ₱' . number_format($balance, 2) . '.');
            }

            foreach ($booking->rooms as $room) {
                $lockedRoom = Room::lockForUpdate()->findOrFail($room->id);

                if (strtolower($lockedRoom->status) !== 'available') {
                    abort(422, 'One or more assigned rooms are not available.');
                }

                $lockedRoom->update([
                    'status' => 'Occupied',
                ]);
            }

            $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

            $booking->update([
                'rfid_card_id' => $lockedCard->id,
                'paid_amount' => $paidAmount,
                'balance' => 0,
                'payment_status' => 'paid',
                'status' => 'checked_in',
                'checked_in_at' => now(),
            ]);

            $lockedCard->update([
                'status' => 'assigned',
            ]);
        });

        return redirect()
            ->route('rfid.front-desk.index')
            ->with('success', 'Guest checked in successfully using RFID.');
    }

    public function checkOut(Request $request, Booking $booking)
    {
        if (strtolower($booking->status) !== 'checked_in') {
            return redirect()
                ->route('rfid.front-desk.index')
                ->withErrors([
                    'checkout' => 'Only checked-in bookings can be checked out.',
                ]);
        }

        $booking->load(['rooms', 'rfidCard', 'payments']);

        $balance = $this->computeBalance($booking);

        if ($balance > 0) {
            return back()->withErrors([
                'checkout' => 'Cannot check out. Guest still has remaining balance of ₱' . number_format($balance, 2),
            ]);
        }

        DB::transaction(function () use ($booking) {
            $booking = Booking::lockForUpdate()->findOrFail($booking->id);
            $booking->load(['rooms', 'rfidCard', 'payments']);

            if (strtolower($booking->status) !== 'checked_in') {
                abort(422, 'This booking is no longer eligible for check-out.');
            }

            $balance = $this->computeBalance($booking);

            if ($balance > 0) {
                abort(422, 'Guest still has remaining balance of ₱' . number_format($balance, 2) . '.');
            }

            $rfidCard = $booking->rfidCard;

            if ($rfidCard) {
                $lockedCard = RfidCard::lockForUpdate()->find($rfidCard->id);

                if ($lockedCard) {
                    $lockedCard->update([
                        'status' => 'available',
                    ]);
                }
            }

            foreach ($booking->rooms as $room) {
                $lockedRoom = Room::lockForUpdate()->find($room->id);

                if ($lockedRoom) {
                    $lockedRoom->update([
                        'status' => 'Dirty',
                    ]);
                }
            }

            $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

            $booking->update([
                'paid_amount' => $paidAmount,
                'balance' => 0,
                'payment_status' => 'paid',
                'status' => 'checked_out',
                'checked_out_at' => now(),
                'rfid_card_id' => null,
            ]);
        });

        return redirect()
            ->route('rfid.front-desk.index')
            ->with('success', 'Guest checked out successfully. RFID card is now available again.');
    }

    private function computeBalance(Booking $booking): float
    {
        $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
        $paidAmount = round((float) $booking->payments()->sum('amount'), 2);

        $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
        $balance = round($grandTotal - $paidAmount, 2);

        return $balance < 0.01 ? 0.00 : $balance;
    }

    public function detect(Request $request)
    {
        $validated = $request->validate([
            'rfid_uid' => ['required', 'string', 'max:255'],
        ]);

        $rfidUid = trim($validated['rfid_uid']);

        $rfidCard = RfidCard::where('uid', $rfidUid)->first();

        if (! $rfidCard) {
            return response()->json([
                'success' => false,
                'message' => 'RFID card is not registered.',
            ], 404);
        }

        if (strtolower($rfidCard->status) === 'available') {
            $bookings = Booking::query()
                ->with(['guest'])
                ->whereIn('status', ['reserved', 'confirmed'])
                ->latest()
                ->get()
                ->map(fn ($booking) => [
                    'id' => $booking->id,
                    'booking_code' => $booking->booking_code,
                    'guest_name' => trim(($booking->guest->first_name ?? '') . ' ' . ($booking->guest->last_name ?? '')),
                    'status' => ucfirst($booking->status),
                    'check_in_url' => route('rfid.front-desk.check-in', $booking),
                ]);

            return response()->json([
                'success' => true,
                'mode' => 'check_in',
                'rfid_uid' => $rfidUid,
                'card_status' => $rfidCard->status,
                'bookings' => $bookings,
            ]);
        }

        if (strtolower($rfidCard->status) === 'assigned') {
            $booking = Booking::query()
                ->with(['guest', 'rooms', 'payments', 'rfidCard'])
                ->where('rfid_card_id', $rfidCard->id)
                ->where('status', 'checked_in')
                ->latest()
                ->first();

            if (! $booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'RFID card is assigned but no active checked-in booking was found.',
                ], 422);
            }

            $chargesTotal = round((float) $booking->activeFolioCharges()->sum('amount'), 2);
            $paidAmount = round((float) $booking->payments()->sum('amount'), 2);
            $grandTotal = round((float) $booking->total_price + $chargesTotal, 2);
            $balance = round($grandTotal - $paidAmount, 2);

            if ($balance < 0.01) {
                $balance = 0.00;
            }

            return response()->json([
                'success' => true,
                'mode' => 'check_out',
                'rfid_uid' => $rfidUid,
                'card_status' => $rfidCard->status,
                'booking' => [
                    'id' => $booking->id,
                    'booking_code' => $booking->booking_code,
                    'guest_name' => trim(($booking->guest->first_name ?? '') . ' ' . ($booking->guest->last_name ?? '')),
                    'rooms' => $booking->rooms->pluck('room_number')->implode(', '),
                    'checked_in_at' => $booking->checked_in_at
                        ? \Carbon\Carbon::parse($booking->checked_in_at)->format('M d, Y h:i A')
                        : 'N/A',
                    'room_total' => number_format((float) $booking->total_price, 2),
                    'charges_total' => number_format($chargesTotal, 2),
                    'paid_amount' => number_format($paidAmount, 2),
                    'balance' => number_format($balance, 2),
                    'raw_balance' => $balance,
                    'folio_url' => route('bookings.folio', $booking),
                    'payment_url' => url('/booking/result/' . $booking->id),
                    'check_out_url' => route('rfid.front-desk.check-out', $booking),
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'This RFID card is not available for check-in or check-out.',
        ], 422);
    }
}
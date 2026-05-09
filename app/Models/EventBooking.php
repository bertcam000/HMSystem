<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_venue_id',
        'booking_code',
        'client_name',
        'client_phone',
        'client_email',
        'event_title',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'guest_count',
        'venue_amount',
        'additional_charges',
        'discount',
        'total_amount',
        'paid_amount',
        'balance',
        'status',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'venue_amount' => 'decimal:2',
        'additional_charges' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = self::generateBookingCode();
            }
        });
    }

    public static function generateBookingCode(): string
    {
        $latest = self::latest('id')->first();

        $nextNumber = $latest ? $latest->id + 1 : 1;

        return 'EVT-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function venue()
    {
        return $this->belongsTo(EventVenue::class, 'event_venue_id');
    }

    public function payments()
    {
        return $this->hasMany(EventPayment::class);
    }

    public function getStartDateTimeAttribute()
    {
        return Carbon::parse($this->event_date->format('Y-m-d') . ' ' . $this->start_time);
    }

    public function getEndDateTimeAttribute()
    {
        return Carbon::parse($this->event_date->format('Y-m-d') . ' ' . $this->end_time);
    }

    public function getDurationHoursAttribute(): float
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        return max($start->floatDiffInHours($end), 0);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'ongoing' => 'bg-purple-100 text-purple-700 border border-purple-200',
            'completed' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'cancelled' => 'bg-red-100 text-red-700 border border-red-200',
            default => 'bg-gray-100 text-gray-700 border border-gray-200',
        };
    }

    public function getPaymentBadgeClassAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid' => 'bg-red-100 text-red-700 border border-red-200',
            'partial' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'paid' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            default => 'bg-gray-100 text-gray-700 border border-gray-200',
        };
    }

    public function refreshPaymentSummary(): void
    {
        $paid = round((float) $this->payments()->sum('amount'), 2);
        $total = round((float) $this->total_amount, 2);
        $balance = max(round($total - $paid, 2), 0);

        $paymentStatus = match (true) {
            $paid <= 0 => 'unpaid',
            $paid >= $total => 'paid',
            default => 'partial',
        };

        $this->update([
            'paid_amount' => $paid,
            'balance' => $balance,
            'payment_status' => $paymentStatus,
        ]);
    }

    public function calculateTotalAmount(): void
    {
        $venue = $this->venue;

        $hours = $this->duration_hours;

        $venueAmount = $venue
            ? round($hours * (float) $venue->rate_per_hour, 2)
            : round((float) $this->venue_amount, 2);

        $additional = round((float) $this->additional_charges, 2);
        $discount = round((float) $this->discount, 2);

        $total = max(round(($venueAmount + $additional) - $discount, 2), 0);

        $this->venue_amount = $venueAmount;
        $this->total_amount = $total;
        $this->balance = max(round($total - (float) $this->paid_amount, 2), 0);

        $this->payment_status = match (true) {
            $this->paid_amount <= 0 => 'unpaid',
            $this->paid_amount >= $total => 'paid',
            default => 'partial',
        };

        $this->save();
    }
}
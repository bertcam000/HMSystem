<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_booking_id',
        'amount',
        'type',
        'method',
        'reference_number',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($payment) {
            $payment->booking?->refreshPaymentSummary();
        });

        static::updated(function ($payment) {
            $payment->booking?->refreshPaymentSummary();
        });

        static::deleted(function ($payment) {
            $payment->booking?->refreshPaymentSummary();
        });
    }

    public function booking()
    {
        return $this->belongsTo(EventBooking::class, 'event_booking_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FolioCharge extends Model
{
    protected $fillable = [
        'booking_id',
        'charge_code',
        'category',
        'description',
        'quantity',
        'unit_price',
        'amount',
        'is_void',
        'void_reason',
        'voided_at',
        'created_by',
        'voided_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
        'is_void' => 'boolean',
        'voided_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function voidedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voided_by');
    }

    protected static function booted(): void
    {
        static::creating(function ($charge) {
            if (!$charge->charge_code) {
                $latestId = self::max('id') + 1;
                $charge->charge_code = 'CHG-' . str_pad($latestId, 6, '0', STR_PAD_LEFT);
            }

            $charge->amount = round($charge->quantity * $charge->unit_price, 2);

            if (auth()->check() && !$charge->created_by) {
                $charge->created_by = auth()->id();
            }
        });

        static::updating(function ($charge) {
            $charge->amount = round($charge->quantity * $charge->unit_price, 2);
        });
    }
}
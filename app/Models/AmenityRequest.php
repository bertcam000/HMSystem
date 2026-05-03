<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmenityRequest extends Model
{
    protected $fillable = [
        'booking_id',
        'folio_charge_id',
        'item_name',
        'category',
        'quantity',
        'unit_price',
        'total_amount',
        'is_chargeable',
        'status',
        'notes',
        'rejection_reason',
        'requested_by',
        'approved_by',
        'fulfilled_by',
        'approved_at',
        'fulfilled_at',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_chargeable' => 'boolean',
        'approved_at' => 'datetime',
        'fulfilled_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function folioCharge(): BelongsTo
    {
        return $this->belongsTo(FolioCharge::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function fulfiller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fulfilled_by');
    }

    protected static function booted(): void
    {
        static::saving(function ($request) {
            $request->total_amount = round(
                (float) $request->quantity * (float) $request->unit_price,
                2
            );
        });
    }

    public function amenityItem()
    {
        return $this->belongsTo(AmenityItem::class);
    }
}
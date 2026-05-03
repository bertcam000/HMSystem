<?php

namespace App\Models;
use App\Models\RfidCard;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\FolioCharge;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];

    // protected $casts = [
    //     'check_in_date' => 'date',
    //     'check_out_date' => 'date',
    //     'checked_in_at' => 'datetime',
    //     'checked_out_at' => 'datetime',
    //     'tax' => 'decimal:2',
    //     'service_charge' => 'decimal:2',
    //     'subtotal' => 'decimal:2',
    //     'total_price' => 'decimal:2',
    //     'paid_amount' => 'decimal:2',
    //     'balance' => 'decimal:2',
    // ];
    protected $cast = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'tax' => 'decimal:2',
        'service_charge' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

   public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms')
            ->withPivot('total_price')
            ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function generateReservationCode()
    {
        $last = self::orderByDesc('id')->first();

        if (!$last) {
            return 'RES-00001';
        }

        $lastNumber = (int) substr($last->booking_code, 4);
        $nextNumber = $lastNumber + 1;

        return 'RES-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];



    public function rfidCard(): BelongsTo
    {
        return $this->belongsTo(RfidCard::class);
    }

    public function hasRfidCard(): bool
    {
        return ! is_null($this->rfid_card_id);
    }
    
    
    public function folioCharges(): HasMany
    {
        return $this->hasMany(FolioCharge::class);
    }

    public function activeFolioCharges(): HasMany
    {
        return $this->hasMany(FolioCharge::class)->where('is_void', false);
    }

    public function getFolioChargesTotalAttribute(): float
    {
        return round($this->activeFolioCharges()->sum('amount'), 2);
    }

    public function getPaidTotalAttribute(): float
    {
        return round($this->payments()->sum('amount'), 2);
    }

    public function getGrandTotalAttribute(): float
    {
        return round($this->total_price + $this->folio_charges_total, 2);
    }

    public function getRemainingBalanceAttribute(): float
    {
        return round(max($this->grand_total - $this->paid_total, 0), 2);
    }
    
    public function amenityRequests(): HasMany
    {
        return $this->hasMany(AmenityRequest::class);
    }
    
}

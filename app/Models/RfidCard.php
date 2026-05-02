<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RfidCard extends Model
{
    protected $fillable = [
        'uid',
        'status',
        'remarks',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function activeBooking()
    {
        return $this->hasOne(Booking::class)
            ->where('status', 'checked_in');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'available' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'assigned' => 'bg-blue-100 text-blue-700 ring-blue-200',
            'lost' => 'bg-red-100 text-red-700 ring-red-200',
            'damaged' => 'bg-amber-100 text-amber-700 ring-amber-200',
            default => 'bg-gray-100 text-gray-700 ring-gray-200',
        };
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventVenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'rate_per_hour',
        'location',
        'status',
    ];

    public function eventBookings()
    {
        return $this->hasMany(EventBooking::class);
    }
}
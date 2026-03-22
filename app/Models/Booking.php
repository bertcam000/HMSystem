<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];

   public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms');
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
    ];
}

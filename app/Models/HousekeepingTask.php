<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HousekeepingTask extends Model
{
    protected $fillable = [
        'room_id',
        'assigned_to',
        'priority',
        'status',
        'notes',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
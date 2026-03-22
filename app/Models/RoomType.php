<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $guarded = ['id'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function images()
    {
        return $this->hasMany(RoomTypeImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'room_type_features');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_type_facilities');
    }
}

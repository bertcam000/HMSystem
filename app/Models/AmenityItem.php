<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenityItem extends Model
{
    protected $fillable = [
        'name',
        'category',
        'unit_price',
        'stock_quantity',
        'minimum_stock',
        'is_chargeable',
        'is_active',
        'description',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'minimum_stock' => 'integer',
        'is_chargeable' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        }

        if ($this->stock_quantity < $this->minimum_stock) {
            return 'low_stock';
        }

        return 'in_stock';
    }
}
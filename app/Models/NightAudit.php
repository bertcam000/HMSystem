<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NightAudit extends Model
{
    protected $fillable = [
        'audit_date',
        'arrivals_count',
        'departures_count',
        'in_house_count',
        'occupied_rooms',
        'available_rooms',
        'daily_revenue',
        'outstanding_balance',
        'pending_checkins_count',
        'pending_checkouts_count',
        'unsettled_accounts_count',
        'summary',
        'audited_at',
        'status',
        'audited_by',
    ];

    protected $casts = [
        'audit_date' => 'date',
        'audited_at' => 'datetime',
        'daily_revenue' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'summary' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'audited_by');
    }
}
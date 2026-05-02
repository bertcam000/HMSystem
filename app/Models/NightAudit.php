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
        'total_reservations',
        'total_cancellations',
        'total_payments',
        'vatable_sales',
        'vat_amount',
        'net_sales',
    ];

    protected $casts = [
        'audit_date' => 'date',
        'audited_at' => 'datetime',
        'daily_revenue' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'summary' => 'array',
        'total_payments' => 'decimal:2',
        'vatable_sales' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'net_sales' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'audited_by');
    }
}
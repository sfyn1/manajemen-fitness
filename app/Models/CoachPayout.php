<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'payout_number',
        'coach_id',
        'payout_type',    // 'monthly_salary' | 'session_fee'
        'month',
        'year',
        'total_sessions', // Untuk group coach
        'base_salary',    // Untuk PT
        'bonus',          // Untuk PT (opsional)
        'total_amount',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'base_salary'  => 'decimal:2',
        'bonus'        => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at'      => 'datetime',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    // Label tipe payroll
    public function getPayoutTypeLabelAttribute(): string
    {
        return $this->payout_type === 'monthly_salary'
            ? 'Gaji Bulanan (PT)'
            : 'Bayaran Sesi (Group Coach)';
    }
}
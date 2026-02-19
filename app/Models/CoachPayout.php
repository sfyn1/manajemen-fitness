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
        'month',
        'year',
        'total_sessions',
        'total_amount',
        'paid_at'
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
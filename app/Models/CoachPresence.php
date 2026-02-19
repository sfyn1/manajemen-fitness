<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachPresence extends Model
{
    use HasFactory;

    // PASTIKAN 'evidence_photo' ADA DISINI
    protected $fillable = [
        'coach_id',
        'schedule_id',
        'date',
        'coach_fee',
        'evidence_photo', // <--- INI KUNCINYA (Tadi mungkin ketinggalan)
        'status'
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
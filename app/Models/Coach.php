<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'photo',
        'coach_type',          // 'personal_trainer' | 'group_coach'
        'base_salary',         // Gaji pokok bulanan (PT)
        'session_rate',        // Bayaran per sesi (Group Coach)
        'class_type_id',       // Spesialisasi kelas (Group Coach)
        'contract_start_date',
        'contract_end_date',
    ];

    protected $casts = [
        'base_salary'         => 'decimal:2',
        'session_rate'        => 'decimal:2',
        'contract_start_date' => 'date',
        'contract_end_date'   => 'date',
    ];

    // --- RELASI ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Spesialisasi kelas (Group Coach)
    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    // Jadwal kelas kelompok yang dipegang coach ini
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Absensi mengajar kelas kelompok
    public function presences()
    {
        return $this->hasMany(CoachPresence::class);
    }

    // Langganan PT yang ditangani coach ini
    public function ptSubscriptions()
    {
        return $this->hasMany(PtSubscription::class);
    }

    // Sesi PT individual
    public function ptSessions()
    {
        return $this->hasMany(PtSession::class);
    }

    // Riwayat slip gaji
    public function payouts()
    {
        return $this->hasMany(CoachPayout::class);
    }

    // --- HELPERS ---

    public function isPersonalTrainer(): bool
    {
        return $this->coach_type === 'personal_trainer';
    }

    public function isGroupCoach(): bool
    {
        return $this->coach_type === 'group_coach';
    }

    public function getCoachTypeLabelAttribute(): string
    {
        return $this->coach_type === 'personal_trainer' ? 'Personal Trainer' : 'Group Class Coach';
    }
}
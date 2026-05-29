<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PtSession extends Model
{
    use HasFactory;

    protected $table = 'pt_sessions';

    protected $fillable = [
        'pt_subscription_id',
        'member_id',
        'coach_id',
        'session_date',
        'start_time',
        'end_time',
        'session_number',
        'status',
        'notes',
        'cancel_reason',
        'cancelled_at',
        'rescheduled_from_date',
        'rescheduled_from_time',
        'rescheduled_at',
    ];

    protected $casts = [
        'session_date'          => 'date',
        'cancelled_at'          => 'datetime',
        'rescheduled_at'        => 'datetime',
        'rescheduled_from_date' => 'date',
    ];

    // --- RELASI ---

    public function subscription()
    {
        return $this->belongsTo(PtSubscription::class, 'pt_subscription_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    // --- HELPERS ---

    // Cek apakah masih bisa dibatalkan (harus H-1 atau lebih awal)
    public function isCancellable(): bool
    {
        if ($this->status !== 'scheduled') return false;
        return Carbon::today()->lt(Carbon::parse($this->session_date));
    }

    // Cek apakah masih bisa di-reschedule (sama dengan H-1)
    public function isReschedulable(): bool
    {
        return $this->isCancellable();
    }

    // Format waktu untuk tampilan
    public function getTimeRangeAttribute(): string
    {
        return Carbon::parse($this->start_time)->format('H:i')
            . ' – '
            . Carbon::parse($this->end_time)->format('H:i');
    }

    // Label status
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'scheduled'  => 'Terjadwal',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            'no_show'    => 'Tidak Hadir',
            default      => ucfirst($this->status),
        };
    }

    // Warna badge
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show'   => 'warning',
            default     => 'secondary',
        };
    }
}

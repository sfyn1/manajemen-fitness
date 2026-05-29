<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PtSubscription extends Model
{
    use HasFactory;

    protected $table = 'pt_subscriptions';

    protected $fillable = [
        'member_id',
        'coach_id',
        'pt_package_id',
        'sessions_total',
        'sessions_used',
        'start_date',
        'end_date',
        'status',
        'payment_status',
        'paid_at',
        'payment_note',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'paid_at'    => 'datetime',
    ];

    // --- RELASI ---

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function package()
    {
        return $this->belongsTo(PtPackage::class, 'pt_package_id');
    }

    public function sessions()
    {
        return $this->hasMany(PtSession::class);
    }

    // --- COMPUTED ATTRIBUTES ---

    // Sisa sesi = total - sudah dipakai
    public function getSessionsLeftAttribute(): int
    {
        return $this->sessions_total - $this->sessions_used;
    }

    // Persentase progres (0–100)
    public function getProgressPercentAttribute(): int
    {
        if ($this->sessions_total === 0) return 0;
        return (int) round(($this->sessions_used / $this->sessions_total) * 100);
    }

    // Cek apakah sudah kadaluarsa
    public function isExpired(): bool
    {
        return $this->end_date && Carbon::today()->gt($this->end_date);
    }

    // Label status (Bahasa Indonesia)
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'Menunggu Konfirmasi',
            'active'    => 'Aktif',
            'completed' => 'Selesai',
            'expired'   => 'Kadaluarsa',
            'cancelled' => 'Dibatalkan',
            default     => ucfirst($this->status),
        };
    }

    // Warna badge Bootstrap untuk status
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'active'    => 'success',
            'completed' => 'primary',
            'expired'   => 'secondary',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'gender',
        'photo',
        'ktp_image',           
        'student_card_image',  
        'join_date',
        'expiry_date',
        'status',
    ];

    // Relasi ke User (Sudah ada sebelumnya)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Presence (Satu Member punya Banyak Kehadiran)
    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    /**
     * Accessor untuk mendapatkan status yang benar berdasarkan tanggal expiry
     * Jika sudah expired, otomatis return 'expired', jika tidak return 'active'
     */
    public function getStatusExpiredAttribute()
    {
        if (Carbon::parse($this->expiry_date)->isPast()) {
            return 'expired';
        }
        return $this->status ?? 'active';
    }

    /**
     * Method untuk update status member jika sudah expired
     * Panggil method ini sebelum menampilkan data member
     */
    public function updateStatusIfExpired()
    {
        if (Carbon::parse($this->expiry_date)->isPast() && $this->status !== 'expired') {
            $this->update(['status' => 'expired']);
        }
        return $this;
    }

    /**
     * Check apakah member sudah expired
     */
    public function isExpired()
    {
        return Carbon::parse($this->expiry_date)->isPast();
    }
}
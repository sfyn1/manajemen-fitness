<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // --- TAMBAHKAN BAGIAN INI ---
    // Relasi ke Presence (Satu Member punya Banyak Kehadiran)
    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}
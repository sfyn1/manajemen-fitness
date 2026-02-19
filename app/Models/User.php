<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // --- TAMBAHAN BARU ---
        'role',                 // admin, owner, coach, member
        'phone_number',         // No HP
        'otp_code',             // Kode OTP
        'otp_expires_at',       // Waktu expired OTP
        'must_change_password', // Status wajib ganti pass
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code', // Sembunyikan OTP agar aman
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',      // Otomatis jadi format waktu
            'must_change_password' => 'boolean', // Otomatis jadi true/false
        ];
    }

    // RELASI: Satu User (Member) memiliki satu data detail Member
    public function member()
    {
        return $this->hasOne(Member::class);
    }

    // RELASI: Satu User (Coach) memiliki satu data detail Coach
    public function coachProfile()
    {
        return $this->hasOne(Coach::class, 'user_id');
    }
    
    // Helper function untuk cek role dengan mudah nanti
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
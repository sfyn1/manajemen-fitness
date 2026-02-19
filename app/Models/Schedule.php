<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // KITA KEMBALI KE HARI, BUKAN TANGGAL
    protected $fillable = [
        'coach_id',
        'class_type_id',
        'day',          // Senin, Selasa, dll
        'start_time',
        'end_time'
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    // Relasi ke Booking (Siapa aja yg booking jadwal ini)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_type_id',
        'coach_id',
        'day',
        'start_time',
        'end_time'
    ];

    // Relasi ke Jenis Kelas
    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    // Relasi ke Pelatih
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
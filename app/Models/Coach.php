<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    // 'specialization' diganti 'class_type_id'
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'photo',
        'class_type_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Pelatih ini "memiliki" satu jenis kelas spesialisasi
    public function classType()
    {
        return $this->belongsTo(ClassType::class, 'class_type_id');
    }

    // Relasi: Pelatih ini "memiliki" banyak jadwal kelas
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
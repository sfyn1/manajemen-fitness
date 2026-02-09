<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    // 'specialization' diganti 'class_type_id'
    protected $fillable = ['name', 'class_type_id', 'phone_number', 'photo'];

    // Relasi: Pelatih ini "memiliki" satu jenis kelas spesialisasi
    public function classType()
    {
        return $this->belongsTo(ClassType::class, 'class_type_id');
    }
}
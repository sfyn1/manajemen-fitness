<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPackage extends Model
{
    use HasFactory;

    // KITA WAJIB MENAMBAHKAN INI (DAFTAR KOLOM YG BOLEH DIISI)
    protected $fillable = [
        'name',
        'duration_in_days',
        'price',
        'description',
    ];
}
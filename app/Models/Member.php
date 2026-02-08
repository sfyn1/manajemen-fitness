<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Field yang boleh diisi
    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'gender',
        'join_date',
        'expiry_date',
        'status',
    ];

    // RELASI: Data Member ini milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
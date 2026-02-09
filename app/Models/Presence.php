<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'check_in_time', 'status'];

    // Relasi ke Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
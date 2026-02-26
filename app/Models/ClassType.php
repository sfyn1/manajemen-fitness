<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'duration_minutes', 'price'];

    // Relasi: Satu tipe kelas punya banyak jadwal
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Relasi: Satu tipe kelas punya banyak coach
    public function coaches()
    {
        return $this->hasMany(Coach::class);
    }
}
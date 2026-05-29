<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtPackage extends Model
{
    use HasFactory;

    protected $table = 'pt_packages';

    protected $fillable = [
        'name',
        'session_count',
        'price',
        'validity_days',
        'duration_minutes',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Langganan yang menggunakan paket ini
    public function subscriptions()
    {
        return $this->hasMany(PtSubscription::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'itemable_id',
        'itemable_type',
        'name',
        'price',
        'quantity',
        'subtotal'
    ];

    // Relasi Polymorphic (Bisa ke Product atau MembershipPackage)
    public function itemable()
    {
        return $this->morphTo();
    }
}
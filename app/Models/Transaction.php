<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'grand_total',
        'status',
        'payment_method',
        'proof_of_payment',
        'transaction_date',
        'processed_by'
    ];

    // Relasi: Transaksi punya banyak detail barang
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // Relasi: Transaksi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
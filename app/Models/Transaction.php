<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code',
        'buyer_id',
        'store_id',
        'address',
        'address_id',
        'city',
        'postal_code',
        'shipping',
        'shipping_type',
        'shipping_cost',
        'tracking_number',
        'tax',
        'grand_total',
        'payment_status',
        'delivery_status',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    // Relasi ke User (sebagai Buyer)
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // Relasi ke Store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Relasi ke Detail (Sesuai nama tabel transaction_details)
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
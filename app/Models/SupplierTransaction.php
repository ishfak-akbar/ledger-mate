<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierTransaction extends Model
{
    protected $fillable = [
        'shop_id',
        'user_id',
        'date',
        'total_amount',
        'paid_amount',
        'due_amount',
        'supplier_name',
        'supplier_phone',
        'supplier_address',
        'description',
        'note',
        'payment_method',
        'transaction_type'
    ];

    protected $casts = [
        'date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
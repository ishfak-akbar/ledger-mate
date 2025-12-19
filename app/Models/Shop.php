<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'category',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function supplierTransactions()
    {
        return $this->hasMany(SupplierTransaction::class);
    }

    public function getSupplierTotalAmountAttribute()
    {
        return $this->supplierTransactions()->sum('total_amount');
    }

    public function getSupplierPaidAmountAttribute()
    {
        return $this->supplierTransactions()->sum('paid_amount');
    }

    public function getSupplierDueAmountAttribute()
    {
        return $this->supplierTransactions()->sum('due_amount');
    }
}
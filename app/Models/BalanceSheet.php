<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_credit',
        'total_debit',
        'balance',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

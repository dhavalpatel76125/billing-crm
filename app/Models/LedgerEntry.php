<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    use HasFactory;

    protected $table = 'ledger_entries';

    protected $fillable = [
        'customer_id',
        'invoice_id',
        'side',       // debit or credit
        'amount',
        'allocated',
        'remarks',
        'entry_at',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'allocated'=> 'boolean',
        'entry_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

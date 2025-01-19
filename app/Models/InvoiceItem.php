<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

    protected $fillable = [
        'invoice_id',
        'description',
        'total',
        'product_id',
        'unit_price',
        'quantity',
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

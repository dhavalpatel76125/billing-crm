<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //table name
    protected $table = 'products';

    //fillable fields
    protected $fillable = ['name', 'description', 'stock'];

    // invoice items function connection

    public function invoiceItems()
    {
        return $this->hasMany('App\Models\InvoiceItem');
    }
}

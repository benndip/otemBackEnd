<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    //
    protected $fillable = [
        'product_id', 'quantity', 'unit_price'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    } 
}

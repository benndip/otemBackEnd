<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'ordered_products');
    }

    public function orderedProducts()
    {
        return $this->hasMany('App\Models\OrderedProduct');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

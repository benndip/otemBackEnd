<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    public function orderedProducts()
    {
        return $this->hasMany('App\Models\OrderedProduct');
    }
}

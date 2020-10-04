<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function productImages()
    {
        return $this->hasMany('App\Models\ProductImage');
    }
}

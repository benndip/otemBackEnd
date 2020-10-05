<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $fillable = [
        'name', 'description', 'category_id', 'price'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function productImages()
    {
        return $this->hasMany('App\Models\ProductImage');
    }
}

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderedProduct;
use Faker\Generator as Faker;
use App\Models\Order;
use App\Models\Product;

$factory->define(OrderedProduct::class, function (Faker $faker) {
    return [
        //
        'order_id'=>factory(Order::class),
        'product_id'=>factory(Product::class),
        'quantity'=>$faker->randomDigit,
        'unit_price'=>$faker->randomDigit,
        'status'=>rand(0,1),
    ];
});

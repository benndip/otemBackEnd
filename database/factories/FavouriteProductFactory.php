<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FavouriteProduct;
use Faker\Generator as Faker;
use App\User;
use App\Models\Product;

$factory->define(FavouriteProduct::class, function (Faker $faker) {
    return [
        //
        'user_id' => factory(User::class),
        'product_id' => factory(Product::class)
    ];
});

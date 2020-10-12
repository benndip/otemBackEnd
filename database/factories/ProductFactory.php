<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use App\Models\Category;

$factory->define(Product::class, function (Faker $faker) {
    return [
        //
        'category_id' => factory(Category::class),
        'name' => factory(Category::class)->create()->name,
        'description' => 'This is a nice Product for you to check out. Thanks!',
        'price' => $faker->randomDigit,
        'available' => Arr::random([0,1]),
    ];
});

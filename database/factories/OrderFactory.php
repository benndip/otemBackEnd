<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use Illuminate\support\Arr;
use App\User;
use App\Models\Product;

$factory->define(Order::class, function (Faker $faker) {
    return [
        //
        'user_id'=>factory(User::class),
        'total_amount'=>$faker->randomDigit,
        'status' =>Arr::random(['new','processing','ontheway','delivered']),
        'paid'=>Arr::random([0,1]),
    ];
});

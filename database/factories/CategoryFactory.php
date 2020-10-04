<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\support\Arr;

$factory->define(Category::class, function (Faker $faker) {
    return [
        //
        'name' => Arr::random([ 'medicated soap', 'normal soap', 'powered soap', 'liquid soap', 'cross stich', 'needed wool' ]),
        'url' => Arr::random([asset('images/crossStich.jpg'),asset('images/liquidSoap.jpg'), asset('mages/medicatedSoap.jpeg'), asset('images/neededWool.jpg'), asset('images/neededWool.jpg'), asset('images/soap.jpg')]),
    ];
});

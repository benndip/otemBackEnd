<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductImage;
use Faker\Generator as Faker;
use App\Models\Product;
use Illuminate\support\Arr;

$factory->define(ProductImage::class, function (Faker $faker) {
    return [
        //
        'product_id' => factory(Product::class),
        'name' => Arr::random([ 'medicated soap', 'normal soap', 'powered soap', 'liquid soap', 'cross stich', 'needed wool' ]),
        'path' => '/images',
        'url' => Arr::random([asset('images/crossStich.jpg'),asset('images/liquidSoap.jpg'), asset('mages/medicatedSoap.jpeg'), asset('images/neededWool.jpg'), asset('images/neededWool.jpg'), asset('images/soap.jpg')])
    ];
});

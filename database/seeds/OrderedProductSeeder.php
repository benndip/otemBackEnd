<?php

use Illuminate\Database\Seeder;
use App\Models\OrderedProduct;

class OrderedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(OrderedProduct::class, 10)->create();
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\FavouriteProduct;

class FavouriteProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(FavouriteProduct::class, 10)->create();
    }
}

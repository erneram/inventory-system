<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Product;
use Faker\Factory as Faker;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $products = Product::all();

        for ($i = 0; $i < 100; $i++) {
            Stock::create([
                'product_id' => $products->random()->id,  // Seleccionar un product_id aleatorio
                'quantity' => $faker->numberBetween(1, 500),  // Cantidad aleatoria entre 1 y 500
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesDetail;
use App\Models\Sale;
use App\Models\Product;
use Faker\Factory as Faker;

class SalesDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $sales = Sale::all();
        $products = Product::all();
        for ($i = 0; $i < 100; $i++) {
            SalesDetail::create([
                'sales_id' => $sales->random()->id,
                'product_id' => $products->random()->id,
                'quantity' => $faker->numberBetween(1, 10),
                'unit_price' => $faker->randomFloat(2, 1, 1000),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Price;
use Faker\Factory as Faker;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear una instancia de Faker para generar datos aleatorios
        $faker = Faker::create();

        // Insertar 100 precios en la tabla 'prices'
        for ($i = 0; $i < 100; $i++) {
            Price::create([
                'product_id' => rand(1, 100),
                'cost_price' => $faker->randomFloat(2, 1, 1000),
                'selling_price' => $faker->randomFloat(2, 1, 1000),
            ]);
        }
    }
}

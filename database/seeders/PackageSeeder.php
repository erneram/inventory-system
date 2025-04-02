<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\Product;
use Faker\Factory as Faker;

class PackageSeeder extends Seeder
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

        // Insertar 100 paquetes en la tabla 'packages'
        for ($i = 0; $i < 100; $i++) {
            Package::create([
                'product_id' => rand(1, 100),  // Seleccionar un product_id aleatorio entre 1 y 100
                'quantity_per_package' => $faker->numberBetween(1, 50),  // Cantidad aleatoria entre 1 y 50
            ]);
        }
    }
}

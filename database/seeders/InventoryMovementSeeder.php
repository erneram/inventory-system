<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\User;
use Faker\Factory as Faker;

class InventoryMovementSeeder extends Seeder
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
        $users = User::all();
        for ($i = 0; $i < 100; $i++) {
            InventoryMovement::create([
                'product_id' => $products->random()->id,
                'user_id' => $users->random()->id,
                'movement_type' => $faker->randomElement(['IN', 'OUT']),
                'quantity' => $faker->numberBetween(1, 100),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\User;
use Faker\Factory as Faker;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();
        for ($i = 0; $i < 100; $i++) {
            Sale::create([
                'user_id' => $users->random()->id,
                'total_price' => $faker->randomFloat(2, 10, 1000),
            ]);
        }
    }
}

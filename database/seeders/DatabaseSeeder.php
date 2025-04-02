<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PriceSeeder::class,
            SaleSeeder::class,
            StockSeeder::class,
            SalesDetailSeeder::class,
            PackageSeeder::class,
            InventoryMovementSeeder::class,
        ]);
    }
}

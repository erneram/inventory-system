<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar categorías de ejemplo
        DB::table('categories')->insert([
            [
                'name' => 'Electronics',
                'type' => 'fisico',
            ],
            [
                'name' => 'Software',
                'type' => 'digital',
            ],
            [
                'name' => 'Services',
                'type' => 'servicio',
            ],
            [
                'name' => 'Books',
                'type' => 'fisico',
            ],
            [
                'name' => 'Music',
                'type' => 'digital',
            ],
        ]);
    }
}

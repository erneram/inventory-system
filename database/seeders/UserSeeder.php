<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $username = Str::random(8);
            $password = $username;

            User::create([
                'name' => $username,
                'last_name' => 'Test', // lastname pegado
                'email' => $username . '@example.com',
                'role' => 'seller',
                'password' => Hash::make($password),
            ]);
        }
    }
}

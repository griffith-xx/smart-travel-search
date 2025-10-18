<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User 1 - Main test user
        User::create([
            'name' => 'Develop User',
            'email' => env('TEST_USER_EMAIL'),
            'password' => Hash::make(env('TEST_USER_PASSWORD')),
        ]);

        // User 2 - Additional test user
        User::create([
            'name' => 'Somchai Wellness',
            'email' => 'somchai@example.com',
            'password' => Hash::make('password'),
        ]);

        // User 3 - Additional test user
        User::create([
            'name' => 'Preeda Relax',
            'email' => 'preeda@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}

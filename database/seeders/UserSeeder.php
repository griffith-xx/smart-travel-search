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
        User::create([
            'name' => 'Develop User',
            'email' => env('TEST_USER_EMAIL'),
            'password' => Hash::make(env('TEST_USER_PASSWORD')),
        ]);
    }
}

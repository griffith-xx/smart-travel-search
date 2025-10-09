<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Develop Admin',
            'email' => env('TEST_ADMIN_EMAIL'),
            'password' => Hash::make(env('TEST_ADMIN_PASSWORD')),
        ]);
    }
}

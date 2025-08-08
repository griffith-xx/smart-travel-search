<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check file existence
        $filePath = database_path('seeders/data/provinces.json');
        if (!file_exists($filePath)) {
            throw new Exception('ไม่พบไฟล์ provinces.json');
        }

        // Read the JSON file and convert it to an array
        $json = file_get_contents($filePath);
        $provinces = json_decode($json, true);

        // Create the provinces in the database
        foreach ($provinces as $province) {
            DB::table('provinces')->insert([
                'province_name_th' => $province['province_name_th'],
                'province_name_en' => $province['province_name_en'],
                'region' => $province['region'],
                'latitude' => $province['latitude'] ?? null,
                'longitude' => $province['longitude'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Output a success message
        $this->command->info('Provinces table seeded successfully!');
    }
}

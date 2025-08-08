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

        // Truncate the provinces table before seeding
        DB::table('provinces')->truncate();

        //Check if Table exists
        if (!DB::getSchemaBuilder()->hasTable('provinces')) {
            throw new Exception('Table provinces does not exist.');
        }

        // Create the provinces in the database
        foreach ($provinces as $province) {
            DB::table('provinces')->insert([
                'name_th' => $province['name_th'],
                'name_en' => $province['name_en'],
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

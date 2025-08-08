<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check file existence
        $filePath = database_path('seeders/data/categories.json');
        if (!file_exists($filePath)) {
            throw new Exception('ไม่พบไฟล์ provinces.json');
        }

        // Read the JSON file and convert it to an array
        $json = file_get_contents($filePath);
        $categories = json_decode($json, true);

        //Check if Table exists
        if (!DB::getSchemaBuilder()->hasTable('categories')) {
            throw new Exception('Table categories does not exist.');
        }

        // Truncate the categories table before seeding
        DB::table('categories')->truncate();

        // Create the categories in the database
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name_th' => $category['name_th'],
                'name_en' => $category['name_en'],
                'parent_category_id' => $category['parent_category_id'] ?? null,
                'icon' => $category['icon'] ?? null,
                'description' => $category['description'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Output a success message
        $this->command->info('Categories table seeded successfully!');
    }
}

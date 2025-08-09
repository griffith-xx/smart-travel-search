<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

abstract class BaseSeeder extends Seeder
{
    /**
     * Seed data from JSON file
     *
     * @param string $fileName
     * @param string $tableName
     * @param array $mapping
     * @return void
     * @throws Exception
     */
    protected function seedFromJson(string $fileName, string $tableName, array $mapping = []): void
    {
        // Check file existence
        $filePath = database_path("seeders/data/{$fileName}");
        if (!file_exists($filePath)) {
            throw new Exception("ไม่พบไฟล์ {$fileName}");
        }

        // Read the JSON file and convert it to an array
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        // Check for JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("ไฟล์ JSON ผิดรูปแบบ: " . json_last_error_msg());
        }

        // Check if Table exists
        if (!DB::getSchemaBuilder()->hasTable($tableName)) {
            throw new Exception("Table {$tableName} does not exist.");
        }

        // Truncate the table before seeding
        DB::table($tableName)->truncate();

        // Create the records in the database
        foreach ($data as $item) {
            $insertData = [];

            // Apply mapping or use default field names
            if (empty($mapping)) {
                $insertData = $item;
            } else {
                foreach ($mapping as $jsonField => $dbField) {
                    $insertData[$dbField] = $item[$jsonField] ?? null;
                }
            }

            // Add timestamps
            $insertData['created_at'] = now();
            $insertData['updated_at'] = now();

            DB::table($tableName)->insert($insertData);
        }

        // Output a success message
        $this->command->info("Table {$tableName} seeded successfully! (" . count($data) . " records)");
    }

    /**
     * Validate required fields in JSON data
     *
     * @param array $data
     * @param array $requiredFields
     * @return void
     * @throws Exception
     */
    protected function validateRequiredFields(array $data, array $requiredFields): void
    {
        foreach ($data as $index => $item) {
            foreach ($requiredFields as $field) {
                if (!array_key_exists($field, $item)) {
                    throw new Exception("Missing required field '{$field}' in record {$index}");
                }
            }
        }
    }
}

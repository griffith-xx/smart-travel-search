<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

abstract class BaseSeeder extends Seeder
{
    protected function seedFromJson(string $fileName, string $tableName, array $mapping = []): void
    {
        // Check file existence
        $filePath = database_path("seeders/data/{$fileName}");
        if (!file_exists($filePath)) {
            throw new Exception("ไม่พบไฟล์ {$fileName}");
        }

        // Read and validate JSON
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("ไฟล์ JSON ผิดรูปแบบ: " . json_last_error_msg());
        }

        // Check if Table exists
        if (!DB::getSchemaBuilder()->hasTable($tableName)) {
            throw new Exception("Table {$tableName} does not exist.");
        }

        // Clear table data safely
        $this->clearTableData($tableName);

        // Insert new data
        foreach ($data as $item) {
            $insertData = $this->prepareInsertData($item, $mapping);
            DB::table($tableName)->insert($insertData);
        }

        $this->command->info("Table {$tableName} seeded successfully! (" . count($data) . " records)");
    }

    /**
     * Clear table data safely (handle foreign key constraints)
     */
    protected function clearTableData(string $tableName): void
    {
        try {
            DB::table($tableName)->truncate();
        } catch (Exception $e) {
            if (str_contains($e->getMessage(), 'foreign key constraint')) {
                $this->command->warn("Cannot truncate {$tableName} due to foreign key constraints. Using DELETE instead.");
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table($tableName)->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } else {
                throw $e;
            }
        }
    }

    /**
     * Prepare data for insertion
     */
    protected function prepareInsertData(array $item, array $mapping): array
    {
        $insertData = [];

        if (empty($mapping)) {
            $insertData = $item;
        }

        foreach ($item as $key => $value) {
            $mappedKey = $mapping[$key] ?? $key;

            if (is_array($value)) {
                $insertData[$mappedKey] = json_encode($value);
            } else {
                $insertData[$mappedKey] = $value;
            }
        }

        $insertData['created_at'] = now();
        $insertData['updated_at'] = now();

        return $insertData;
    }
}

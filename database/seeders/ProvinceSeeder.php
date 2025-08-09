<?php

namespace Database\Seeders;

class ProvinceSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedFromJson('provinces.json', 'provinces');
    }
}

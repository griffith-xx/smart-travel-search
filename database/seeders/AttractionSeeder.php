<?php

namespace Database\Seeders;

class AttractionSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedFromJson('attractions.json', 'attractions');
    }
}

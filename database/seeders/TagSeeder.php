<?php

namespace Database\Seeders;


class TagSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedFromJson('tags.json', 'tags');
    }
}

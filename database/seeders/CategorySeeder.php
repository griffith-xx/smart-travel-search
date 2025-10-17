<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'สปาและนวด',
                'name_en' => 'Spa & Massage',
                'description' => 'สถานที่ให้บริการสปา นวดแผนไทย นวดน้ำมัน และทรีทเมนท์เพื่อการผ่อนคลาย',
                'image_url' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8c3BhfGVufDB8fDB8fHww&auto=format&fit=crop&q=60&w=500',
                'is_popular' => true,
                'sort_order' => 1
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

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
            [
                'name' => 'โยคะและสมาธิ',
                'name_en' => 'Yoga & Meditation',
                'description' => 'ศูนย์โยคะ สถานที่ทำสมาธิ และกิจกรรมเพื่อความสงบใจ',
                'image_url' => 'https://plus.unsplash.com/premium_photo-1661777196224-bfda51e61cfd?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8eW9nYXxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&q=60&w=500',
                'is_popular' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'รีสอร์ทเพื่อสุขภาพ',
                'name_en' => 'Health Resort',
                'description' => 'รีสอร์ทที่เน้นการดูแลสุขภาพ มีโปรแกรมฟื้นฟูร่างกายและจิตใจ',
                'image_url' => 'https://plus.unsplash.com/premium_photo-1661763857435-1ce8bff6d61e?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170',
                'is_popular' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'ธรรมชาติบำบัด',
                'name_en' => 'Nature Therapy',
                'description' => 'สถานที่ท่องเที่ยวเชิงธรรมชาติ เดินป่า ปีนเขา และกิจกรรมกลางแจ้ง',
                'image_url' => 'https://images.unsplash.com/photo-1585125793268-a67cddbe7d6c?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170',
                'is_popular' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'อาหารเพื่อสุขภาพ',
                'name_en' => 'Healthy Food',
                'description' => 'ร้านอาหารออร์แกนิค โปรแกรมดีท็อกซ์ และอาหารเพื่อสุขภาพ',
                'image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170',
                'is_popular' => false,
                'sort_order' => 5
            ],
            [
                'name' => 'การแพทย์แผนไทย',
                'name_en' => 'Thai Traditional Medicine',
                'description' => 'สถานที่ให้บริการการแพทย์แผนไทย สมุนไพร และการรักษาแบบดั้งเดิม',
                'image_url' => 'https://plus.unsplash.com/premium_photo-1661682708486-9896951f5232?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170',
                'is_popular' => false,
                'sort_order' => 6
            ],
            [
                'name' => 'ออนเซ็นและน้ำแร่',
                'name_en' => 'Hot Spring & Mineral Water',
                'description' => 'แหล่งน้ำแร่ธรรมชาติ ออนเซ็น และบ่อน้ำร้อนเพื่อการบำบัด',
                'image_url' => 'https://images.unsplash.com/photo-1734244362947-749db3efc7b7?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170',
                'is_popular' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'ฟิตเนสและกีฬา',
                'name_en' => 'Fitness & Sports',
                'description' => 'ศูนย์ฟิตเนส สนามกีฬา และกิจกรรมออกกำลังกาย',
                'image_url' => 'https://plus.unsplash.com/premium_photo-1675691961167-bc318e524340?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170',
                'is_popular' => false,
                'sort_order' => 8
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

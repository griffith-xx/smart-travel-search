<?php

namespace Database\Seeders;

use App\Models\Category;
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
                'image_url' => '',
                'is_popular' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'โยคะและสมาธิ',
                'name_en' => 'Yoga & Meditation',
                'description' => 'สตูดิโอโยคะ ศูนย์ปฏิบัติธรรม และสถานที่สำหรับฝึกสมาธิเพื่อความสงบของจิตใจ',
                'image_url' => '',
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'บ่อน้ำพุร้อนและออนเซ็น',
                'name_en' => 'Hot Springs & Onsen',
                'description' => 'สถานที่ให้บริการแช่น้ำพุร้อนธรรมชาติหรือออนเซ็นสไตล์ญี่ปุ่นเพื่อสุขภาพและการผ่อนคลาย',
                'image_url' => '',
                'is_popular' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'ศูนย์สุขภาพและเวลเนสรีทรีท',
                'name_en' => 'Health & Wellness Retreat',
                'description' => 'โปรแกรมดูแลสุขภาพแบบองค์รวมที่พักค้างคืน เช่น โปรแกรมดีท็อกซ์ การควบคุมน้ำหนัก',
                'image_url' => '',
                'is_popular' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'คลินิกความงามและเสริมความงาม',
                'name_en' => 'Beauty & Aesthetics Clinic',
                'description' => 'คลินิกที่ให้บริการด้านความงาม การดูแลผิวพรรณ ทรีทเมนท์ใบหน้าและเรือนร่าง',
                'image_url' => '',
                'is_popular' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'ฟิตเนสและกิจกรรมกีฬา',
                'name_en' => 'Fitness & Sports',
                'description' => 'ยิม ฟิตเนส สนามมวยไทย หรือกิจกรรมกีฬาต่างๆ เพื่อการออกกำลังกายและสุขภาพที่แข็งแรง',
                'image_url' => '',
                'is_popular' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'การบำบัดทางเลือก',
                'name_en' => 'Alternative Therapy',
                'description' => 'ศาสตร์การบำบัดอื่นๆ เช่น การฝังเข็ม กายภาพบำบัด หรือการแพทย์แผนไทยประยุกต์',
                'image_url' => '',
                'is_popular' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'โรงแรมและที่พัก',
                'name_en' => 'Hotel & Accommodation',
                'description' => 'โรงแรม รีสอร์ท และที่พักต่างๆ ที่มีบริการด้านสุขภาพ เช่น สปา ฟิตเนส หรืออาหารเพื่อสุขภาพ',
                'image_url' => '',
                'is_popular' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'โรงพยาบาลและศูนย์การแพทย์',
                'name_en' => 'Hospital & Medical Center',
                'description' => 'โรงพยาบาลที่ให้บริการตรวจสุขภาพ โปรแกรมดูแลสุขภาพเฉพาะทาง หรือศูนย์การแพทย์ต่างๆ',
                'image_url' => '',
                'is_popular' => false,
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

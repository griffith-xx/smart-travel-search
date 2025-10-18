<?php

namespace Database\Seeders;

use App\Models\FeatureKeyword;
use Illuminate\Database\Seeder;

class FeatureKeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keywords = [
            [
                'name' => 'ผ่อนคลาย',
                'slug' => 'relaxation',
                'description' => 'สถานที่และกิจกรรมที่ช่วยให้ร่างกายและจิตใจผ่อนคลาย',
            ],
            [
                'name' => 'ธรรมชาติ',
                'slug' => 'nature',
                'description' => 'สถานที่ที่อยู่ท่ามกลางธรรมชาติ',
            ],
            [
                'name' => 'หรูหรา',
                'slug' => 'luxury',
                'description' => 'บริการและสิ่งอำนวยความสะดวกระดับพรีเมียม',
            ],
            [
                'name' => 'ออร์แกนิก',
                'slug' => 'organic',
                'description' => 'ผลิตภัณฑ์และอาหารออร์แกนิก',
            ],
            [
                'name' => 'สมุนไพร',
                'slug' => 'herbal',
                'description' => 'การใช้สมุนไพรไทยในการดูแลสุขภาพ',
            ],
            [
                'name' => 'ดีท็อกซ์',
                'slug' => 'detox',
                'description' => 'โปรแกรมล้างพิษร่างกาย',
            ],
            [
                'name' => 'ลดน้ำหนัก',
                'slug' => 'weight-loss',
                'description' => 'โปรแกรมควบคุมและลดน้ำหนัก',
            ],
            [
                'name' => 'สมาธิ',
                'slug' => 'meditation',
                'description' => 'การฝึกสมาธิเพื่อสุขภาพจิต',
            ],
            [
                'name' => 'นวดแผนไทย',
                'slug' => 'thai-massage',
                'description' => 'การนวดแผนไทยดั้งเดิม',
            ],
            [
                'name' => 'สปา',
                'slug' => 'spa',
                'description' => 'บริการสปาและทรีทเมนท์',
            ],
            [
                'name' => 'โยคะ',
                'slug' => 'yoga',
                'description' => 'การฝึกโยคะทุกระดับ',
            ],
            [
                'name' => 'น้ำพุร้อน',
                'slug' => 'hot-spring',
                'description' => 'บ่อน้ำพุร้อนธรรมชาติ',
            ],
        ];

        foreach ($keywords as $keyword) {
            FeatureKeyword::create($keyword);
        }
    }
}

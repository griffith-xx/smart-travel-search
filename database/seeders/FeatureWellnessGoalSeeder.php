<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeatureWellnessGoal;

class FeatureWellnessGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wellnessGoals = [
            [
                'name' => 'การผ่อนคลายและลดความเครียด',
                'slug' => 'stress_relief_relaxation',
                'description' => 'กิจกรรมที่ช่วยผ่อนคลายจิตใจ ลดความเครียด และฟื้นฟูพลังงาน',
            ],
            [
                'name' => 'การออกกำลังกายและฟิตเนส',
                'slug' => 'fitness_exercise',
                'description' => 'กิจกรรมการออกกำลังกาย กีฬา และการเสริมสร้างสุขภาพร่างกาย',
            ],
            [
                'name' => 'การดูแลสุขภาพจิต',
                'slug' => 'mental_health_wellness',
                'description' => 'กิจกรรมที่ส่งเสริมสุขภาพจิต การทำสมาธิ และความสงบใจ',
            ],
            [
                'name' => 'การดีท็อกซ์และล้างพิษ',
                'slug' => 'detox_cleansing',
                'description' => 'โปรแกรมการล้างพิษในร่างกาย การปรับสมดุลของร่างกาย',
            ],
            [
                'name' => 'การพัฒนาตนเองและจิตวิญญาณ',
                'slug' => 'self_development_spiritual',
                'description' => 'การเรียนรู้และพัฒนาตนเอง การเชื่อมต่อกับจิตวิญญาณภายใน',
            ],
            [
                'name' => 'การนวดและสปาเพื่อสุขภาพ',
                'slug' => 'therapeutic_massage_spa',
                'description' => 'บริการนวดแผนไทย นวดน้ำมัน และทรีทเมนท์สปาเพื่อการรักษาและฟื้นฟู',
            ],
            [
                'name' => 'การรักษาด้วยธรรมชาติและสมุนไพร',
                'slug' => 'natural_herbal_healing',
                'description' => 'การรักษาและดูแลสุขภาพด้วยวิธีธรรมชาติ สมุนไพรไทย และภูมิปัญญาท้องถิน',
            ],
            [
                'name' => 'การท่องเที่ยวเชิงนิเวศเพื่อสุขภาพ',
                'slug' => 'eco_wellness_tourism',
                'description' => 'การท่องเที่ยวในธรรมชาติ Forest Bathing และการเชื่อมต่อกับสิ่งแวดล้อม',
                'icon' => '🌳'
            ],
            [
                'name' => 'การเรียนรู้วัฒนธรรมสุขภาพไทย',
                'slug' => 'thai_wellness_culture',
                'description' => 'การเรียนรู้และสัมผัสภูมิปัญญาการดูแลสุขภาพแบบไทยโบราณ',
            ],
            [
                'name' => 'การฟื้นฟูหลังการเจ็บป่วย',
                'slug' => 'recovery_rehabilitation',
                'description' => 'โปรแกรมฟื้นฟูสุขภาพหลังการเจ็บป่วย การผ่าตัด หรือการรักษา',
            ]
        ];

        foreach ($wellnessGoals as $goal) {
            FeatureWellnessGoal::create($goal);
        }
    }
}

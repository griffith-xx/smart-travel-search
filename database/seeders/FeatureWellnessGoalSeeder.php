<?php

namespace Database\Seeders;

use App\Models\FeatureWellnessGoal;
use Illuminate\Database\Seeder;

class FeatureWellnessGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wellnessGoals = [
            [
                'name' => 'พักผ่อนและคลายเครียด',
                'slug' => 'relax_and_stress_relief',
                'description' => 'กิจกรรมที่ช่วยให้ผ่อนคลาย ลดความเครียด และฟื้นฟูสมดุลทางร่างกายและจิตใจ',
            ],
            [
                'name' => 'ออกกำลังกายและดูแลสุขภาพ',
                'slug' => 'exercise_and_fitness',
                'description' => 'กิจกรรมการออกกำลังกายเพื่อเสริมสร้างความแข็งแรงและสุขภาพที่ดี',
            ],
            [
                'name' => 'ดูแลสุขภาพจิตใจ',
                'slug' => 'mental_health_care',
                'description' => 'กิจกรรมที่ช่วยส่งเสริมสุขภาพจิตและความสงบทางอารมณ์ เช่น การทำสมาธิหรือโยคะ',
            ],
            [
                'name' => 'นวดหรือสปาเพื่อผ่อนคลาย',
                'slug' => 'massage_and_spa',
                'description' => 'การนวด สปา และทรีทเมนท์เพื่อคลายความเมื่อยล้าและฟื้นฟูพลังงาน',
            ],
            [
                'name' => 'ท่องเที่ยวธรรมชาติและฟื้นฟูร่างกาย',
                'slug' => 'nature_and_body_recovery',
                'description' => 'การเดินทางท่องเที่ยวเชิงธรรมชาติ เพื่อพักผ่อนและฟื้นฟูสุขภาพกายใจ',
            ],
        ];

        foreach ($wellnessGoals as $goal) {
            FeatureWellnessGoal::create($goal);
        }
    }
}

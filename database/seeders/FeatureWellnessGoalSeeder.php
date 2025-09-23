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
                'description' => 'กิจกรรมที่ช่วยผ่อนคลายจิตใจ ลดความเครียด และฟื้นฟูพลังงาน'
            ],
            [
                'name' => 'การออกกำลังกายและฟิตเนส',
                'slug' => 'fitness_exercise',
                'description' => 'กิจกรรมการออกกำลังกาย กีฬา และการเสริมสร้างสุขภาพร่างกาย'
            ],
            [
                'name' => 'การดูแลสุขภาพจิต',
                'slug' => 'mental_health_wellness',
                'description' => 'กิจกรรมที่ส่งเสริมสุขภาพจิต การทำสมาธิ และความสงบใจ'
            ],
            [
                'name' => 'การดีท็อกซ์และล้างพิษ',
                'slug' => 'detox_cleansing',
                'description' => 'โปรแกรมการล้างพิษในร่างกาย การปรับสมดุลของร่างกาย'
            ],
            [
                'name' => 'การนวดและสปา',
                'slug' => 'massage_spa',
                'description' => 'บริการนวดแผนไทย นวดน้ำมัน และทรีทเมนท์สปาต่างๆ'
            ],
            [
                'name' => 'การทำสมาธิและโยคะ',
                'slug' => 'meditation_yoga',
                'description' => 'การฝึกสมาธิ โยคะ และกิจกรรมที่เชื่อมโยงจิตใจกับร่างกาย'
            ],
            [
                'name' => 'การรักษาด้วยธรรมชาติ',
                'slug' => 'natural_healing',
                'description' => 'การรักษาและดูแลสุขภาพด้วยวิธีธรรมชาติ สมุนไพร'
            ],
            [
                'name' => 'การปรับสมดุลชีวิต',
                'slug' => 'life_balance',
                'description' => 'การหาสมดุลระหว่างการทำงานและชีวิตส่วนตัว'
            ],
            [
                'name' => 'การเสริมสร้างพลังงานบวก',
                'slug' => 'positive_energy',
                'description' => 'กิจกรรมที่ช่วยเสริมสร้างพลังงานบวกและความมั่นใจ'
            ],
            [
                'name' => 'การดูแลผิวพรรณและความงาม',
                'slug' => 'beauty_skincare',
                'description' => 'ทรีทเมนท์ดูแลผิวพรรณ ความงาม และการต่อต้านวัย'
            ]
        ];

        foreach ($wellnessGoals as $goal) {
            FeatureWellnessGoal::create($goal);
        }
    }
}

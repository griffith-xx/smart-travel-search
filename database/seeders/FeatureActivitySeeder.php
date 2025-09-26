<?php

namespace Database\Seeders;

use App\Models\FeatureActivity;
use Illuminate\Database\Seeder;

class FeatureActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'name' => 'โยคะและการทำสมาธิ',
                'slug' => 'yoga_meditation',
                'description' => 'การฝึกโยคะ การทำสมาธิ และการหายใจเพื่อความสงบใจ',
                'icon' => '🧘‍♀️'
            ],
            [
                'name' => 'การนวดและสปาทรีทเมนท์',
                'slug' => 'massage_spa_treatment',
                'description' => 'นวดแผนไทย นวดน้ำมัน และทรีทเมนท์สปาเพื่อผ่อนคลาย',
                'icon' => '💆‍♀️'
            ],
            [
                'name' => 'การออกกำลังกายในธรรมชาติ',
                'slug' => 'nature_fitness',
                'description' => 'เดินป่า ปีนเขา ว่ายน้ำ และกิจกรรมกีฬากลางแจ้ง',
                'icon' => '🏃‍♂️'
            ],
            [
                'name' => 'การดีท็อกซ์และอาหารเพื่อสุขภาพ',
                'slug' => 'detox_healthy_nutrition',
                'description' => 'โปรแกรมล้างพิษ อาหารออร์แกนิค และการปรับสมดุลร่างกาย',
                'icon' => '🥗'
            ],
            [
                'name' => 'การรักษาด้วยสมุนไพรและธรรมชาติ',
                'slug' => 'herbal_natural_healing',
                'description' => 'การรักษาด้วยสมุนไพรไทย การอบสมุนไพร และธรรมชาติบำบัด',
                'icon' => '🌿'
            ]
        ];

        foreach ($activities as $activity) {
            FeatureActivity::create($activity);
        }
    }
}

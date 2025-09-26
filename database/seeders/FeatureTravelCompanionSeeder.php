<?php

namespace Database\Seeders;

use App\Models\FeatureTravelCompanion;
use Illuminate\Database\Seeder;

class FeatureTravelCompanionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $travelCompanions = [
            [
                'name' => 'เดินทางคนเดียว',
                'slug' => 'solo_travel',
                'description' => 'การเดินทางเพื่อค้นหาตัวเอง พัฒนาตนเอง และสร้างประสบการณ์ส่วนตัว เหมาะสำหรับการทำสมาธิและการผ่อนคลาย',
                'icon' => '🧘‍♀️'
            ],
            [
                'name' => 'คู่รัก/คู่สามีภรรยา',
                'slug' => 'couple_travel',
                'description' => 'การเดินทางเพื่อเสริมสร้างความสัมพันธ์ ใช้เวลาร่วมกัน และสร้างความทรงจำดีๆ ในบรรยากาศโรแมนติก',
                'icon' => '💕'
            ],
            [
                'name' => 'ครอบครัว',
                'slug' => 'family_travel',
                'description' => 'การเดินทางที่เหมาะสำหรับทุกวัย กิจกรรมที่ปลอดภัย และสร้างความผูกพันในครอบครัว',
                'icon' => '👨‍👩‍👧‍👦'
            ],
            [
                'name' => 'กลุ่มเพื่อน',
                'slug' => 'friends_group',
                'description' => 'การเดินทางแบบกลุ่ม แบ่งปันประสบการณ์ร่วมกัน กิจกรรมที่สนุกสนานและสร้างความสัมพันธ์ที่ดี',
                'icon' => '👥'
            ],
            [
                'name' => 'กลุ่มองค์กร/บริษัท',
                'slug' => 'corporate_group',
                'description' => 'โปรแกรมสำหรับองค์กรและบริษัท เน้นการสร้างทีมเวิร์ค การผ่อนคลายจากการทำงาน และเสริมสร้างขวัญกำลังใจ',
                'icon' => '🏢'
            ]
        ];

        foreach ($travelCompanions as $companion) {
            FeatureTravelCompanion::create($companion);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\FeatureHealthRestriction;
use Illuminate\Database\Seeder;

class FeatureHealthRestrictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $healthRestrictions = [
            [
                'name' => 'ไม่มีข้อจำกัดด้านสุขภาพ',
                'slug' => 'no_health_restrictions',
                'description' => 'เหมาะสำหรับผู้ที่มีสุขภาพแข็งแรง ไม่มีข้อจำกัดพิเศษ สามารถเข้าร่วมกิจกรรมได้ทุกประเภท',
                'icon' => '💪'
            ],
            [
                'name' => 'ข้อจำกัดด้านการเคลื่อนไหว',
                'slug' => 'mobility_restrictions',
                'description' => 'เหมาะสำหรับผู้ที่มีข้อจำกัดในการเดิน ปีนป่าย หรือการเคลื่อนไหวที่ต้องใช้แรงมาก',
                'icon' => '♿'
            ],
            [
                'name' => 'โรคหัวใจและความดันโลหิต',
                'slug' => 'heart_blood_pressure',
                'description' => 'โปรแกรมที่เหมาะสำหรับผู้ที่มีปัญหาหัวใจ ความดันโลหิตสูง หรือต้องหลีกเลี่ยงกิจกรรมหนัก',
                'icon' => '❤️'
            ],
            [
                'name' => 'โรคเบาหวานและเมตาบอลิซึม',
                'slug' => 'diabetes_metabolism',
                'description' => 'โปรแกรมที่คำนึงถึงการควบคุมน้ำตาล อาหารพิเศษ และการออกกำลังกายที่เหมาะสม',
                'icon' => '🩺'
            ],
            [
                'name' => 'ปัญหาระบบทางเดินหายใจ',
                'slug' => 'respiratory_issues',
                'description' => 'เหมาะสำหรับผู้ที่มีปัญหาหอบหืด ภูมิแพ้ หรือปัญหาระบบทางเดินหายใจ ต้องการสภาพแวดล้อมที่เหมาะสม',
                'icon' => '🫁'
            ]
        ];

        foreach ($healthRestrictions as $restriction) {
            FeatureHealthRestriction::create($restriction);
        }
    }
}

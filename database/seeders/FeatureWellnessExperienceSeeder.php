<?php

namespace Database\Seeders;

use App\Models\FeatureWellnessExperience;
use Illuminate\Database\Seeder;

class FeatureWellnessExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wellnessExperiences = [
            [
                'name' => 'ไม่เคยมีประสบการณ์',
                'slug' => 'no_experience',
                'description' => 'ไม่เคยเข้าร่วมกิจกรรมเพื่อสุขภาพหรือโปรแกรม wellness มาก่อน ต้องการเริ่มต้นใหม่',
            ],
            [
                'name' => 'เคยลองบ้างเป็นครั้งคราว',
                'slug' => 'occasional_experience',
                'description' => 'เคยเข้าร่วมกิจกรรมเพื่อสุขภาพบ้างเป็นครั้งคราว เช่น โยคะ สปา หรือการนวด',
            ],
            [
                'name' => 'มีประสบการณ์เป็นประจำ',
                'slug' => 'regular_experience',
                'description' => 'เข้าร่วมกิจกรรมเพื่อสุขภาพเป็นประจำ มีความรู้พื้นฐานและเข้าใจหลักการต่างๆ',
            ],
            [
                'name' => 'มีประสบการณ์มากมาย',
                'slug' => 'extensive_experience',
                'description' => 'มีประสบการณ์ในกิจกรรมเพื่อสุขภาพหลากหลายรูปแบบ เคยเข้าร่วมโปรแกรมต่างๆ มาแล้วหลายครั้ง',
            ],
            [
                'name' => 'เป็นผู้เชี่ยวชาญ/ผู้สอน',
                'slug' => 'expert_instructor',
                'description' => 'เป็นผู้เชี่ยวชาญหรือผู้สอนด้าน wellness มีความรู้ลึกและประสบการณ์มากมาย',
            ],
        ];

        foreach ($wellnessExperiences as $experience) {
            FeatureWellnessExperience::create($experience);
        }
    }
}

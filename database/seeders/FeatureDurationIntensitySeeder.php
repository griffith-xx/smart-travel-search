<?php

namespace Database\Seeders;

use App\Models\FeatureDurationIntensity;
use Illuminate\Database\Seeder;

class FeatureDurationIntensitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $durationIntensities = [
            [
                'name' => 'พักผ่อนระยะสั้น',
                'slug' => 'short_relaxation',
                'description' => 'โปรแกรม 1-2 วัน เน้นการพักผ่อนเบาๆ เหมาะสำหรับวันหยุดสุดสัปดาห์',
            ],
            [
                'name' => 'ฟื้นฟูระยะกลาง',
                'slug' => 'moderate_recovery',
                'description' => 'โปรแกรม 3-5 วัน เน้นการฟื้นฟูร่างกายและจิตใจ กิจกรรมปานกลาง',
            ],
            [
                'name' => 'เปลี่ยนแปลงเชิงลึก',
                'slug' => 'intensive_transformation',
                'description' => 'โปรแกรม 1-2 สัปดาห์ เน้นการเปลี่ยนแปลงวิถีชีวิต กิจกรรมเข้มข้น',
            ],
            [
                'name' => 'การรักษาแบบองค์รวม',
                'slug' => 'holistic_healing',
                'description' => 'โปรแกรม 2-4 สัปดาห์ การรักษาและฟื้นฟูแบบครบวงจร',
            ],
            [
                'name' => 'การเปลี่ยนแปลงชีวิต',
                'slug' => 'life_transformation',
                'description' => 'โปรแกรมระยะยาว 1 เดือนขึ้นไป เปลี่ยนแปลงวิถีชีวิตอย่างถาวร',
            ],
        ];

        foreach ($durationIntensities as $duration) {
            FeatureDurationIntensity::create($duration);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\FeatureEnvironment;
use Illuminate\Database\Seeder;

class FeatureEnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $environments = [
            [
                'name' => 'ป่าและธรรมชาติ',
                'slug' => 'forest_and_nature',
                'description' => 'พื้นที่ป่าและธรรมชาติที่อุดมสมบูรณ์ เหมาะสำหรับการพักผ่อนและสูดอากาศบริสุทธิ์',
            ],
            [
                'name' => 'ภูเขาและที่สูง',
                'slug' => 'mountain_and_highland',
                'description' => 'บรรยากาศภูเขาและที่ราบสูง อากาศเย็นสบาย วิวทิวทัศน์สวยงาม เหมาะสำหรับการฟื้นฟูพลังงานและจิตใจ',
            ],
            [
                'name' => 'ชายทะเลและเกาะ',
                'slug' => 'beach_and_island',
                'description' => 'บรรยากาศชายทะเลและเกาะ ลมทะเลพัดเย็น เสียงคลื่นช่วยผ่อนคลาย เหมาะกับการพักผ่อนและกิจกรรมทางน้ำ',
            ],
            [
                'name' => 'ชนบทและไร่นา',
                'slug' => 'countryside_and_farm',
                'description' => 'บรรยากาศชนบทไทย วิถีชีวิตเรียบง่าย รายล้อมด้วยทุ่งนาและสวน เหมาะสำหรับการเรียนรู้และพักใจ',
            ],
            [
                'name' => 'น้ำตกและลำธาร',
                'slug' => 'waterfall_and_stream',
                'description' => 'พื้นที่น้ำตกและลำธารธรรมชาติ เสียงน้ำไหลและอากาศเย็นสบาย เหมาะสำหรับการผ่อนคลายและทำสมาธิ',
            ],
        ];

        foreach ($environments as $environment) {
            FeatureEnvironment::create($environment);
        }
    }
}

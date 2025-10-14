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
                'slug' => 'forest_nature',
                'description' => 'สภาพแวดล้อมป่าไผ่ ป่าดิบ และธรรมชาติที่อุดมสมบูรณ์ เหมาะสำหรับการผ่อนคลายและสูดอากาศบริสุทธิ์',
            ],
            [
                'name' => 'ภูเขาและที่สูง',
                'slug' => 'mountain_highland',
                'description' => 'บรรยากาศภูเขาและที่ราบสูง อากาศเย็นสบาย วิวทิวทัศน์สวยงาม เหมาะสำหรับการฟื้นฟูพลังงาน',
            ],
            [
                'name' => 'ชายทะเลและเกาะ',
                'slug' => 'beach_island',
                'description' => 'บรรยากาศชายทะเลและเกาะแก้ว เสียงคลื่นทะเล ลมทะเล เหมาะสำหรับการผ่อนคลายและกิจกรรมทางน้ำ',
            ],
            [
                'name' => 'ชนบทและไร่นา',
                'slug' => 'countryside_farm',
                'description' => 'บรรยากาศชนบทไทย ไร่นา สวนผลไม้ วิถีชีวิตเรียบง่าย เหมาะสำหรับการเรียนรู้และสัมผัสธรรมชาติ',
            ],
            [
                'name' => 'น้ำตกและลำธาร',
                'slug' => 'waterfall_stream',
                'description' => 'บรรยากาศน้ำตกและลำธาร เสียงน้ำไหล อากาศชื้นเย็น เหมาะสำหรับการทำสมาธิและผ่อนคลาย',
            ]
        ];

        foreach ($environments as $environment) {
            FeatureEnvironment::create($environment);
        }
    }
}

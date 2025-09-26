<?php

namespace Database\Seeders;

use App\Models\FeatureBudgetAccommodation;
use Illuminate\Database\Seeder;

class FeatureBudgetAccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $budgetAccommodations = [
            [
                'name' => 'งบประมาณประหยัด',
                'slug' => 'budget_friendly',
                'description' => 'ที่พักและกิจกรรมราคาประหยัด เหมาะสำหรับนักเดินทางที่ต้องการประสบการณ์ดีๆ ในราคาที่จับต้องได้',
                'icon' => '💰'
            ],
            [
                'name' => 'งบประมาณปานกลาง',
                'slug' => 'moderate_budget',
                'description' => 'ที่พักและบริการระดับกลาง สมดุลระหว่างคุณภาพและราคา เหมาะสำหรับการพักผ่อนแบบสบายๆ',
                'icon' => '💳'
            ],
            [
                'name' => 'งบประมาณระดับพรีเมียม',
                'slug' => 'premium_budget',
                'description' => 'ที่พักและบริการระดับพรีเมียม คุณภาพสูง สิ่งอำนวยความสะดวกครบครัน',
                'icon' => '💎'
            ],
            [
                'name' => 'งบประมาณหรูหรา',
                'slug' => 'luxury_budget',
                'description' => 'ที่พักและบริการระดับหรูหรา ประสบการณ์พิเศษ บริการส่วนตัว และสิ่งميعที่สะดวกระดับโลก',
                'icon' => '👑'
            ],
            [
                'name' => 'งบประมาณไม่จำกัด',
                'slug' => 'unlimited_budget',
                'description' => 'ประสบการณ์ระดับ Ultra Luxury ไม่มีข้อจำกัดด้านงบประมาณ บริการแบบ VIP และประสบการณ์ที่หาไม่ได้ที่ไหน',
                'icon' => '✨'
            ]
        ];

        foreach ($budgetAccommodations as $budget) {
            FeatureBudgetAccommodation::create($budget);
        }
    }
}

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
                'name' => 'ประหยัด',
                'slug' => 'budget_friendly',
                'description' => 'ที่พักและกิจกรรมราคาประหยัด เหมาะสำหรับนักเดินทางที่ต้องการประสบการณ์ดีๆ ในราคาที่จับต้องได้',
            ],
            [
                'name' => 'ปานกลาง',
                'slug' => 'moderate_budget',
                'description' => 'ที่พักและบริการระดับกลาง สมดุลระหว่างคุณภาพและราคา เหมาะสำหรับการพักผ่อนแบบสบายๆ',
            ],
            [
                'name' => 'ระดับพรีเมียม',
                'slug' => 'premium_budget',
                'description' => 'ที่พักและบริการระดับพรีเมียม คุณภาพสูง สิ่งอำนวยความสะดวกครบครัน',
            ],
            [
                'name' => 'หรูหรา',
                'slug' => 'luxury_budget',
                'description' => 'ที่พักและบริการระดับหรูหรา ประสบการณ์พิเศษ บริการส่วนตัว และสิ่งอำนวยความสะดวกชั้นยอด',
            ],

        ];

        foreach ($budgetAccommodations as $budget) {
            FeatureBudgetAccommodation::create($budget);
        }
    }
}

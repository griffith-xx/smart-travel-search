<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            [
                'name' => 'ขอนแก่น',
                'name_en' => 'Khon Kaen',
                'description' => 'เมืองหลวงของภาคอีสาน ศูนย์กลางการศึกษาและเศรษฐกิจ มีมหาวิทยาลัยขอนแก่นที่มีชื่อเสียง และเป็นเมืองที่มีความเจริญทางด้านการแพทย์',
                'latitude' => 16.4322,
                'longitude' => 102.8236,
                'region' => 'northeast',
                'image_url' => 'https://i.ytimg.com/vi/fF_QQ91wa4w/maxresdefault.jpg',
                'is_popular' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'หนองคาย',
                'name_en' => 'Nong Khai',
                'description' => 'จังหวัดชายแดนติดกับลาว มีแม่น้ำโขงเป็นเส้นแบ่งเขต มีสะพานมิตรภาพไทย-ลาว และเป็นประตูสู่ประเทศลาว มีวัฒนธรรมผสมผสานระหว่างไทยและลาว',
                'latitude' => 17.8782,
                'longitude' => 102.7412,
                'region' => 'northeast',
                'image_url' => 'https://www.ktc.co.th/pub/media/Article/11/nong-4.webp',
                'is_popular' => true,
                'sort_order' => 2
            ],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'province_id' => 2, // จังหวัดหนองคาย
                'name' => 'รีสอร์ทริมโขง',
                'slug' => 'resort-rim-khong',
                'name_en' => 'Mekong Riverside Resort',
                'description' => 'รีสอร์ทริมแม่น้ำโขง บรรยากาศสงบ เหมาะสำหรับการพักผ่อนและฟื้นฟูร่างกาย มีบริการนวดแผนไทย โยคะ และกิจกรรมเพื่อสุขภาพ',
                'latitude' => 17.8782,
                'longitude' => 102.7433,
                'address' => '123 ถนนริมโขง ตำบลในเมือง อำเภอเมืองหนองคาย จังหวัดหนองคาย 43000',
                'cover_image' => 'https://www.chillpainai.com/src/wewakeup/scoop/img_scoop/ben_study_2016/july/kong_resort/raisang/1.jpg',
                'price_from' => 2500.00,
                'price_to' => 5000.00,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'province_id' => 2, // จังหวัดหนองคาย
                'name' => 'ศูนย์สุขภาพธรรมชาติภูผาเทพ',
                'slug' => 'phu-pha-thep-wellness-center',
                'name_en' => 'Phu Pha Thep Natural Wellness Center',
                'description' => 'ศูนย์สุขภาพท่ามกลางธรรมชาติ มีโปรแกรมดีท็อกซ์ การรักษาด้วยสมุนไพร และกิจกรรมเดินป่าเพื่อสุขภาพ',
                'latitude' => 17.9234,
                'longitude' => 102.6891,
                'address' => '456 หมู่ 5 ตำบลภูเขาทอง อำเภอเมืองหนองคาย จังหวัดหนองคาย 43000',
                'cover_image' => 'https://www.chaipat.or.th/images/stories/flexicontent/l_image001.jpg',
                'price_from' => 3000.00,
                'price_to' => 7000.00,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'province_id' => 2, // จังหวัดหนองคาย
                'name' => 'บ้านพักสุขภาพวัดหินหมากเป้ง',
                'slug' => 'wat-hin-mak-peng-wellness-home',
                'name_en' => 'Wat Hin Mak Peng Wellness Home',
                'description' => 'บ้านพักสุขภาพใกล้วัดหินหมากเป้ง บรรยากาศเงียบสงบ เหมาะสำหรับการทำสมาธิ ปฏิบัติธรรม และพักผ่อนเพื่อสุขภาพจิต',
                'latitude' => 17.8956,
                'longitude' => 102.7123,
                'address' => '789 หมู่ 3 ตำบลหินโงม อำเภอเมืองหนองคาย จังหวัดหนองคาย 43000',
                'cover_image' => 'https://cms.dmpcdn.com/travel/2023/05/21/c9763500-f7b2-11ed-b1ae-3b957a94e8d6_webp_original.jpg',
                'price_from' => 1500.00,
                'price_to' => 3500.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'province_id' => 2, // จังหวัดหนองคาย
                'name' => 'สปาและรีสอร์ทศาลาแก้วกู่',
                'slug' => 'sala-kaew-ku-spa-resort',
                'name_en' => 'Sala Kaew Ku Spa & Resort',
                'description' => 'รีสอร์ทและสปาใกล้สวนประติมากรรมศาลาแก้วกู่ มีบริการนวดน้ำมันหอมระเหย สปาทรีทเมนท์ และโปรแกรมผ่อนคลาย',
                'latitude' => 17.8645,
                'longitude' => 102.7589,
                'address' => '321 ถนนประชาสามัคคี ตำบลในเมือง อำเภอเมืองหนองคาย จังหวัดหนองคาย 43000',
                'cover_image' => 'https://cms.dmpcdn.com/travel/2024/10/16/b0b63b00-8b72-11ef-afdd-b700adfe3c5c_webp_original.webp',
                'price_from' => 2000.00,
                'price_to' => 4500.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'province_id' => 2, // จังหวัดหนองคาย
                'name' => 'ศูนย์โยคะและสมาธิริมน้ำ',
                'slug' => 'riverside-yoga-meditation-center',
                'name_en' => 'Riverside Yoga & Meditation Center',
                'description' => 'ศูนย์ฝึกโยคะและสมาธิริมแม่น้ำโขง บรรยากาศสงบ มีครูผู้เชี่ยวชาญ เหมาะสำหรับผู้เริ่มต้นและผู้มีประสบการณ์',
                'latitude' => 17.8823,
                'longitude' => 102.7312,
                'address' => '654 หมู่ 7 ตำบลโพธิ์ชัย อำเภอเมืองหนองคาย จังหวัดหนองคาย 43000',
                'cover_image' => 'https://res.klook.com/images/fl_lossy.progressive,q_65/c_fill,w_1295,h_863/w_80,x_15,y_15,g_south_west,l_Klook_water_br_trans_yhcmh3/activities/k2ku1pwynvinxwr82hka/%E0%B8%AA%E0%B8%B1%E0%B8%A1%E0%B8%9C%E0%B8%B1%E0%B8%AA%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%AA%E0%B8%9A%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%93%E0%B9%8C%E0%B9%82%E0%B8%A2%E0%B8%84%E0%B8%B0%E0%B9%81%E0%B8%A5%E0%B8%B0%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%97%E0%B8%B3%E0%B8%AA%E0%B8%A1%E0%B8%B2%E0%B8%98%E0%B8%B4%E0%B8%A3%E0%B8%B4%E0%B8%A1%E0%B8%8A%E0%B8%B2%E0%B8%A2%E0%B8%AB%E0%B8%B2%E0%B8%94%E0%B8%97%E0%B8%B5%E0%B9%88KelapaRetreatSpa.jpg',
                'price_from' => 1000.00,
                'price_to' => 2500.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}

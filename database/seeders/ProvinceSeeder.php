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
                'name' => 'กรุงเทพมหานคร',
                'name_en' => 'Bangkok',
                'description' => 'เมืองหลวงของประเทศไทย ศูนย์กลางทางเศรษฐกิจ การคมนาคม และวัฒนธรรม มีสถานที่ท่องเที่ยวหลากหลายทั้งวัดวาอาราม พระบรมมหาราชวัง แหล่งช้อปปิ้ง และสถานบันเทิงยามค่ำคืน',
                'latitude' => 13.7563,
                'longitude' => 100.5018,
                'region' => 'central',
                'image_url' => 'https://i.natgeofe.com/n/e06ce9b7-4a57-4b95-a50e-346c21e51c1d/thailand-bangkok-temple.jpg',
                'is_popular' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'เชียงใหม่',
                'name_en' => 'Chiang Mai',
                'description' => 'เมืองใหญ่อันดับสองของไทย มีชื่อเสียงด้านธรรมชาติที่สวยงาม วัฒนธรรมล้านนาที่เป็นเอกลักษณ์ และอากาศที่เย็นสบาย มีวัดวาอารามเก่าแก่และดอยสุเทพเป็นสัญลักษณ์',
                'latitude' => 18.7883,
                'longitude' => 98.9853,
                'region' => 'north',
                'image_url' => 'https://www.holidify.com/images/bgImages/CHIANG-MAI.jpg',
                'is_popular' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'ภูเก็ต',
                'name_en' => 'Phuket',
                'description' => 'เกาะที่ใหญ่ที่สุดในประเทศไทย มีชื่อเสียงด้านชายหาดที่สวยงาม น้ำทะเลสีคราม และกิจกรรมทางน้ำที่หลากหลาย เป็นแหล่งท่องเที่ยวยอดนิยมระดับโลก',
                'latitude' => 7.8804,
                'longitude' => 98.3922,
                'region' => 'south',
                'image_url' => 'https://media.timeout.com/images/105992925/750/422/image.jpg',
                'is_popular' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'ชลบุรี',
                'name_en' => 'Chonburi',
                'description' => 'จังหวัดชายทะเลภาคตะวันออก มีเมืองพัทยาเป็นแหล่งท่องเที่ยวที่มีชื่อเสียงระดับนานาชาติ มีชายหาด แหล่งบันเทิง และสวนน้ำมากมาย',
                'latitude' => 13.3611,
                'longitude' => 100.9847,
                'region' => 'east',
                'image_url' => 'https://www.dusit.com/dusitthani-pattaya/wp-content/uploads/sites/11/2021/04/Pattaya-Beach-scaled.jpg',
                'is_popular' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'กระบี่',
                'name_en' => 'Krabi',
                'description' => 'จังหวัดชายฝั่งทะเลอันดามัน มีชื่อเสียงด้านหมู่เกาะที่สวยงาม เช่น หมู่เกาะพีพี อ่าวมาหยา และหาดไร่เลย์ มีหน้าผาหินปูนที่เป็นเอกลักษณ์',
                'latitude' => 8.0863,
                'longitude' => 98.9063,
                'region' => 'south',
                'image_url' => 'https://a.cdn-hotels.com/gdcs/production16/d1223/04a35120-0382-4848-a0c8-113e61386d3b.jpg',
                'is_popular' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'สุราษฎร์ธานี',
                'name_en' => 'Surat Thani',
                'description' => 'เมืองร้อยเกาะ มีเกาะสมุย เกาะพะงัน และเกาะเต่าเป็นแหล่งท่องเที่ยวยอดนิยม มีชื่อเสียงด้านหาดทรายขาว น้ำทะเลใส และกิจกรรมฟูลมูนปาร์ตี้',
                'latitude' => 9.1401,
                'longitude' => 99.3331,
                'region' => 'south',
                'image_url' => 'https://www.royalcoasttravel.com/wp-content/uploads/2023/11/Surat-Thani-Attractions.jpg',
                'is_popular' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'พระนครศรีอยุธยา',
                'name_en' => 'Phra Nakhon Si Ayutthaya',
                'description' => 'อดีตราชธานีของไทย มีชื่อเสียงด้านโบราณสถานและวัดวาอารามเก่าแก่ที่ได้รับการขึ้นทะเบียนเป็นมรดกโลก',
                'latitude' => 14.3517,
                'longitude' => 100.5774,
                'region' => 'central',
                'image_url' => 'https://content.r9cdn.net/rimg/dimg/58/6a/d283623e-city-21695-1649983949.jpg?width=1366&height=768&xhint=1543&yhint=1097&crop=true',
                'is_popular' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'เชียงราย',
                'name_en' => 'Chiang Rai',
                'description' => 'จังหวัดเหนือสุดของไทย มีชื่อเสียงด้านวัดร่องขุ่น (วัดขาว) และบ้านดำ มีธรรมชาติที่สวยงามและวัฒนธรรมที่เป็นเอกลักษณ์',
                'latitude' => 19.9105,
                'longitude' => 99.8406,
                'region' => 'north',
                'image_url' => 'https://media.cntraveller.in/wp-content/uploads/2019/04/GettyImages-627768514-866x487.jpg',
                'is_popular' => true,
                'sort_order' => 8
            ],
            [
                'name' => 'กาญจนบุรี',
                'name_en' => 'Kanchanaburi',
                'description' => 'มีชื่อเสียงด้านประวัติศาสตร์สมัยสงครามโลกครั้งที่ 2 สะพานข้ามแม่น้ำแคว และธรรมชาติที่อุดมสมบูรณ์ เช่น น้ำตกเอราวัณ และเขื่อนศรีนครินทร์',
                'latitude' => 14.021,
                'longitude' => 99.531,
                'region' => 'west',
                'image_url' => 'https://www.tripsavvy.com/thmb/pXAZA-Y11Bpj34y-2KxJER1hJbY=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/river-kwai-bridge-in-kanchanaburi--thailand-1209355382-7f7f3f26947047918a0b06253b2f5d96.jpg',
                'is_popular' => true,
                'sort_order' => 9
            ],
            [
                'name' => 'เพชรบุรี',
                'name_en' => 'Phetchaburi',
                'description' => 'เมืองที่มีประวัติศาสตร์ยาวนาน มีพระราชวังและวัดเก่าแก่ที่สวยงาม มีชื่อเสียงด้านขนมหวาน และมีหาดชะอำเป็นแหล่งพักตากอากาศยอดนิยม',
                'latitude' => 13.1121,
                'longitude' => 99.9458,
                'region' => 'west',
                'image_url' => 'https://files.thailand-guide.com/wp-content/uploads/2023/10/26130959/phetchaburi-12.jpg',
                'is_popular' => true,
                'sort_order' => 10
            ],
            [
                'name' => 'ขอนแก่น',
                'name_en' => 'Khon Kaen',
                'description' => 'หนึ่งในสี่เมืองหลักของภาคอีสาน เป็นศูนย์กลางทางการค้าและการคมนาคม มีสถานที่ท่องเที่ยวหลากหลาย เช่น พระมหาธาตุแก่นนคร และอุทยานแห่งชาติภูเวียง',
                'latitude' => 16.4322,
                'longitude' => 102.8236,
                'region' => 'northeast',
                'image_url' => 'https://i.ytimg.com/vi/fF_QQ91wa4w/maxresdefault.jpg',
                'is_popular' => true,
                'sort_order' => 11
            ],
            [
                'name' => 'หนองคาย',
                'name_en' => 'Nong Khai',
                'description' => 'จังหวัดชายแดนริมแม่น้ำโขง ประตูสู่เวียงจันทน์ ประเทศลาว มีชื่อเสียงด้านประติมากรรมศาลาแก้วกู่และตลาดท่าเสด็จ.',
                'latitude' => 17.8782,
                'longitude' => 102.7412,
                'region' => 'northeast',
                'image_url' => 'https://www.ktc.co.th/pub/media/Article/11/nong-4.webp',
                'is_popular' => true,
                'sort_order' => 12
            ],
            [
                'name' => 'อุดรธานี',
                'name_en' => 'Udon Thani',
                'description' => 'เป็นหนึ่งในสี่เมืองใหญ่ของภาคอีสานและเป็นศูนย์กลางการค้าที่สำคัญ. เป็นประตูสู่ประเทศลาว เวียดนามตอนเหนือ และจีนตอนใต้. มีชื่อเสียงด้านแหล่งโบราณคดีบ้านเชียง',
                'latitude' => 17.4157,
                'longitude' => 102.7859,
                'region' => 'northeast',
                'image_url' => 'https://static.smarttravelapp.com/data/pois/556_talaybuadang2_1582625906.jpg',
                'is_popular' => true,
                'sort_order' => 13
            ],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
}

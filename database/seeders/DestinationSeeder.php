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
                // Basic Information
                'province_id' => 1, // ขอนแก่น
                'category_id' => 1, // ที่พัก
                'name' => 'โรงแรมพูลแมน ขอนแก่น ราชา ออคิด',
                'name_en' => 'Pullman Khon Kaen Raja Orchid',
                'description' => 'โรงแรมหรู 5 ดาวใจกลางเมืองขอนแก่น ตกแต่งด้วยสถาปัตยกรรมร่วมสมัยผสมผสานเอกลักษณ์อีสาน ห้องพักกว้างขวางพร้อมสิ่งอำนวยความสะดวกครบครัน มีสระว่ายน้ำขนาดใหญ่ ฟิตเนสเซ็นเตอร์ สปา ห้องอาหารนานาชาติและอาหารอีสานต้นตำรับ ห้องประชุมและจัดงานอีเว้นท์ ใกล้ศูนย์การค้าเซ็นทรัลพลาซา เหมาะสำหรับนักท่องเที่ยวและนักธุรกิจ',
                'short_description' => 'โรงแรมหรู 5 ดาวใจกลางเมืองขอนแก่น พร้อมสิ่งอำนวยความสะดวกครบครัน',

                // Location & Contact
                'latitude' => 16.4322,
                'longitude' => 102.8236,
                'address' => '9/9 ถนนประชาสโมสร',
                'district' => 'เมืองขอนแก่น',
                'subdistrict' => 'ในเมือง',
                'postal_code' => '40000',
                'phone' => '043-322-155',
                'email' => 'info@pullmankhonkaen.com',
                'website' => 'https://pullmankhonkaen.com',
                'line_id' => '@pullmankhonkaen',
                'facebook' => 'facebook.com/pullmankhonkaen',
                'instagram' => 'instagram.com/pullmankhonkaen',

                // Media
                'cover_image' => 'https://www.ahstatic.com/photos/1877_ho_02_p_1024x768.jpg',
                'gallery_images' => [
                    'https://ak-d.tripcdn.com/images/0223a12000ipzmcgxE447_R_600_400_R5.webp',
                    'https://ak-d.tripcdn.com/images/02261120009c8s3am07C5_R_600_400_R5.webp',
                    'https://ak-d.tripcdn.com/images/0222512000c37qt4gD3D9_R_600_400_R5.webp',
                    'https://ak-d.tripcdn.com/images/0224712000f1vaf58B752_R_600_400_R5.webp',
                    'https://ak-d.tripcdn.com/images/0586s12000ns05oyeAF3B_R_600_400_R5.webp',
                ],
                'video_url' => null,
                'virtual_tour_url' => null,

                // Pricing & Booking
                'price_from' => 2800,
                'price_to' => 8500,
                'currency' => 'THB',
                'pricing_note' => 'ราคาอาจเปลี่ยนแปลงตามฤดูกาล วันหยุดนักขัตฤกษ์ และช่วงงานประเพณีอีสาน',
                'accepts_online_booking' => true,
                'booking_url' => 'https://booking.pullmankhonkaen.com',

                // Ratings & Reviews
                'average_rating' => 4.6,
                'total_reviews' => 2150,
                'total_bookings' => 8900,
                'view_count' => 25000,
                'favorite_count' => 1450,

                // SEO & Marketing
                'meta_title' => 'โรงแรมพูลแมน ขอนแก่น ราชา ออคิด - โรงแรม 5 ดาวใจกลางเมืองขอนแก่น',
                'meta_description' => 'จองโรงแรมหรู 5 ดาวใจกลางเมืองขอนแก่น พร้อมสิ่งอำนวยความสะดวกครบครัน ใกล้เซ็นทรัลพลาซา ราคาพิเศษ',
                'meta_keywords' => json_encode(['โรงแรมขอนแก่น', 'โรงแรม 5 ดาว ขอนแก่น', 'ที่พักขอนแก่น', 'พูลแมน ขอนแก่น', 'โรงแรมใกล้เซ็นทรัล ขอนแก่น']),
                'og_image' => 'https://www.ahstatic.com/photos/1877_ho_02_p_1024x768.jpg',

                // Special Features
                'has_parking' => true,
                'has_wifi' => true,
                'has_restaurant' => true,
                'pet_friendly' => false,

                // Admin & Status
                'is_active' => true,
                'is_featured' => true,
                'is_recommended' => true,
                'sort_order' => 1,
                'admin_notes' => 'โรงแรมคุณภาพดีเยี่ยม ได้รับการรับรองมาตรฐาน SHA+ และรางวัลต่างๆ มากมาย เป็นโรงแรมชั้นนำของจังหวัดขอนแก่น',
                'published_at' => now(),
            ],
        ];

        foreach ($destinations as $destination) {
            $destinationCreate =  Destination::create($destination);

            $preferences = [
                'wellness_goals' => [1, 3, 4],
                'activities' => [1, 2],
                'environments' => [2, 3],
                'duration_intensity_id' => 2,
                'budget_accommodation_id' => 1,
                'keywords' => ['โรงแรม', 'ขอนแก่น', 'พูลแมน'],
            ];

            $destinationCreate->preference()->update($preferences);
        };
    }
}

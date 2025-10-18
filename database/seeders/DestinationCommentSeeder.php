<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\DestinationComment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DestinationCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() >= 3) {
            // Divana Spa comments
            $divanaSpa = Destination::where('name_en', 'LIKE', '%Divana Spa%')->first();
            if ($divanaSpa) {
                $comment1 = DestinationComment::create([
                    'user_id' => $users[1]->id, // Somchai
                    'destination_id' => $divanaSpa->id,
                    'parent_id' => null,
                    'content' => 'สถานที่สวยมาก บรรยากาศดี นวดสบายมาก แนะนำเลยค่ะ',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                // Reply from Develop User
                DestinationComment::create([
                    'user_id' => $users[0]->id,
                    'destination_id' => $divanaSpa->id,
                    'parent_id' => $comment1->id,
                    'content' => 'ราคาเท่าไหร่คะ',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                $comment1->increment('replies_count');
            }

            // Yoga Retreat Chiang Mai comments
            $yogaRetreat = Destination::where('name_en', 'LIKE', '%Yoga Retreat Chiang Mai%')->first();
            if ($yogaRetreat) {
                $comment2 = DestinationComment::create([
                    'user_id' => $users[0]->id, // Develop User
                    'destination_id' => $yogaRetreat->id,
                    'parent_id' => null,
                    'content' => 'เหมาะกับคนอยากหาที่ผ่อนคลายจริงๆ ธรรมชาติดี อากาศเย็น โยคะครูสอนดี',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                // Reply from Preeda
                DestinationComment::create([
                    'user_id' => $users[2]->id,
                    'destination_id' => $yogaRetreat->id,
                    'parent_id' => $comment2->id,
                    'content' => 'เห็นด้วยเลยค่ะ ชอบมาก',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                $comment2->increment('replies_count');
            }

            // Hin Dad Hot Spring comments
            $hinDad = Destination::where('name_en', 'LIKE', '%Hin Dad Hot Spring%')->first();
            if ($hinDad) {
                $comment3 = DestinationComment::create([
                    'user_id' => $users[2]->id, // Preeda
                    'destination_id' => $hinDad->id,
                    'parent_id' => null,
                    'content' => 'น้ำพุร้อนธรรมชาติ บรรยากาศดีมาก ราคาไม่แพง คุ้มค่ามาก!',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                // Reply from Somchai
                DestinationComment::create([
                    'user_id' => $users[1]->id,
                    'destination_id' => $hinDad->id,
                    'parent_id' => $comment3->id,
                    'content' => 'ไปช่วงไหนดีครับ หน้าฝนไปได้ไหม',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                $comment3->increment('replies_count');
            }

            // Wellness Resort Phuket comments
            $wellnessResort = Destination::where('name_en', 'LIKE', '%Wellness Resort Phuket%')->first();
            if ($wellnessResort) {
                DestinationComment::create([
                    'user_id' => $users[0]->id, // Develop User
                    'destination_id' => $wellnessResort->id,
                    'parent_id' => null,
                    'content' => 'โปรแกรมดีท็อกซ์ดีมาก อาหารอร่อย พนักงานบริการดี ทะเลสวย คุ้มค่ากับราคา',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                DestinationComment::create([
                    'user_id' => $users[1]->id, // Somchai
                    'destination_id' => $wellnessResort->id,
                    'parent_id' => null,
                    'content' => 'ห้องพักสะอาด วิวสวย สปาดีมาก แนะนำค่ะ',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);
            }

            // Nature Spa Resort comments
            $natureSpa = Destination::where('name_en', 'LIKE', '%Nature Spa Resort%')->first();
            if ($natureSpa) {
                DestinationComment::create([
                    'user_id' => $users[0]->id, // Develop User
                    'destination_id' => $natureSpa->id,
                    'parent_id' => null,
                    'content' => 'วิวสวย อากาศดี สปาเยี่ยม แนะนำให้มาพักผ่อนครับ',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);

                DestinationComment::create([
                    'user_id' => $users[2]->id, // Preeda
                    'destination_id' => $natureSpa->id,
                    'parent_id' => null,
                    'content' => 'ชอบบรรยากาศธรรมชาติมาก เหมาะสำหรับการพักผ่อน',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);
            }

            // Luxury Spa Phuket comments
            $luxurySpa = Destination::where('name_en', 'LIKE', '%Luxury Spa Phuket%')->first();
            if ($luxurySpa) {
                DestinationComment::create([
                    'user_id' => $users[1]->id, // Somchai
                    'destination_id' => $luxurySpa->id,
                    'parent_id' => null,
                    'content' => 'หรูหรามาก บริการดีเยี่ยม คุ้มค่าที่จ่ายไป แนะนำเลยครับ',
                    'images' => null,
                    'likes_count' => 0,
                    'replies_count' => 0,
                    'is_approved' => true,
                    'is_edited' => false,
                ]);
            }
        }
    }
}

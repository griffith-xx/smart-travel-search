<?php

namespace Database\Seeders;

use App\Models\CommentLike;
use App\Models\DestinationComment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() >= 3) {
            // Get all comments
            $allComments = DestinationComment::all();

            // User 1 - Develop User likes these comments
            $user1LikeComments = $allComments->filter(function ($comment) {
                return in_array($comment->content, [
                    'สถานที่สวยมาก บรรยากาศดี นวดสบายมาก แนะนำเลยค่ะ',
                    'น้ำพุร้อนธรรมชาติ บรรยากาศดีมาก ราคาไม่แพง คุ้มค่ามาก!',
                    'ห้องพักสะอาด วิวสวย สปาดีมาก แนะนำค่ะ',
                    'ชอบบรรยากาศธรรมชาติมาก เหมาะสำหรับการพักผ่อน',
                ]);
            });

            foreach ($user1LikeComments as $comment) {
                CommentLike::create([
                    'user_id' => $users[0]->id,
                    'comment_id' => $comment->id,
                ]);
                $comment->increment('likes_count');
            }

            // User 2 - Somchai likes these comments
            $user2LikeComments = $allComments->filter(function ($comment) {
                return in_array($comment->content, [
                    'เหมาะกับคนอยากหาที่ผ่อนคลายจริงๆ ธรรมชาติดี อากาศเย็น โยคะครูสอนดี',
                    'โปรแกรมดีท็อกซ์ดีมาก อาหารอร่อย พนักงานบริการดี ทะเลสวย คุ้มค่ากับราคา',
                    'วิวสวย อากาศดี สปาเยี่ยม แนะนำให้มาพักผ่อนครับ',
                    'เห็นด้วยเลยค่ะ ชอบมาก',
                ]);
            });

            foreach ($user2LikeComments as $comment) {
                CommentLike::create([
                    'user_id' => $users[1]->id,
                    'comment_id' => $comment->id,
                ]);
                $comment->increment('likes_count');
            }

            // User 3 - Preeda likes these comments
            $user3LikeComments = $allComments->filter(function ($comment) {
                return in_array($comment->content, [
                    'สถานที่สวยมาก บรรยากาศดี นวดสบายมาก แนะนำเลยค่ะ',
                    'เหมาะกับคนอยากหาที่ผ่อนคลายจริงๆ ธรรมชาติดี อากาศเย็น โยคะครูสอนดี',
                    'วิวสวย อากาศดี สปาเยี่ยม แนะนำให้มาพักผ่อนครับ',
                    'ไปช่วงไหนดีครับ หน้าฝนไปได้ไหม',
                ]);
            });

            foreach ($user3LikeComments as $comment) {
                CommentLike::create([
                    'user_id' => $users[2]->id,
                    'comment_id' => $comment->id,
                ]);
                $comment->increment('likes_count');
            }
        }
    }
}

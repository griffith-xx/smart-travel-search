<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $destinations = Destination::where('is_active', true)->get();

        if ($users->isEmpty() || $destinations->isEmpty()) {
            $this->command->warn('No users or destinations found. Skipping review seeding.');

            return;
        }

        $reviewTexts = [
            [
                'title' => 'ประสบการณ์ที่ยอดเยี่ยม',
                'comment' => 'สถานที่นี้สวยงามมาก บรรยากาศผ่อนคลาย เหมาะสำหรับการพักผ่อนและฟื้นฟูสุขภาพ พนักงานบริการดีมาก แนะนำให้มาลองเลยครับ',
                'rating' => 5,
            ],
            [
                'title' => 'ดีมาก คุ้มค่า',
                'comment' => 'มาครั้งนี้ประทับใจมาก สถานที่สะอาด อาหารอร่อย กิจกรรมหลากหลาย ราคาไม่แพง จะมาอีกแน่นอน',
                'rating' => 5,
            ],
            [
                'title' => 'ดี แต่ยังมีข้อควรปรับปรุง',
                'comment' => 'โดยรวมแล้วดีครับ แต่บางจุดยังไม่ค่อยสะดวก เช่น ที่จอดรถน้อยไป ห้องน้ำควรเพิ่มความสะอาด แต่บริการดี พนักงานน่ารัก',
                'rating' => 4,
            ],
            [
                'title' => 'บรรยากาศดี สงบ',
                'comment' => 'ชอบบรรยากาศที่นี่มาก สงบ ร่มรื่น เหมาะกับการมาปลีกวิเวกและทำสมาธิ อากาศดี น้ำใส สวย',
                'rating' => 5,
            ],
            [
                'title' => 'พอใช้ได้ ไม่เลวแต่ก็ไม่เด่น',
                'comment' => 'มาลองแล้วรู้สึกว่าก็โอเคนะครับ แต่ไม่ได้โดดเด่นอะไรมากมาย ราคาก็ปานกลาง ถ้ามีโอกาสอาจจะลองหาที่ใหม่ดูบ้าง',
                'rating' => 3,
            ],
            [
                'title' => 'สถานที่เงียบสงบ เหมาะกับการพักผ่อน',
                'comment' => 'เป็นสถานที่ที่เงียบสงบมาก ไม่มีเสียงรบกวน อากาศดี วิวสวย เหมาะสำหรับคนที่ต้องการหนีความวุ่นวายในเมือง',
                'rating' => 5,
            ],
            [
                'title' => 'บริการดี พนักงานเป็นกันเอง',
                'comment' => 'ประทับใจบริการมากครับ พนักงานทุกคนยิ้มแย้ม ช่วยเหลือดีมาก ให้คำแนะนำต่างๆ ที่เป็นประโยชน์ รู้สึกเหมือนมาบ้านญาติ',
                'rating' => 5,
            ],
            [
                'title' => 'ราคาแพงไปหน่อย',
                'comment' => 'คุณภาพก็ดีนะครับ แต่รู้สึกว่าราคาแพงไปหน่อยเมื่อเทียบกับสิ่งที่ได้รับ ถ้าลดราคาหน่อยน่าจะดีกว่านี้',
                'rating' => 3,
            ],
            [
                'title' => 'กิจกรรมหลากหลายดี',
                'comment' => 'ชอบที่นี่มีกิจกรรมให้เลือกทำเยอะมาก ทั้งโยคะ สปา นวดแผนไทย ทำสมาธิ แต่ละอย่างก็มีครูที่ประสบการณ์คอยสอน',
                'rating' => 4,
            ],
            [
                'title' => 'อาหารอร่อยมาก',
                'comment' => 'อาหารที่นี่อร่อยมากครับ เน้นอาหารเพื่อสุขภาพ สด สะอาด รสชาติดี ส่วนผสมมีคุณภาพ แม้จะเป็นอาหารเจก็ทำให้อิ่มและอร่อย',
                'rating' => 5,
            ],
            [
                'title' => 'วิวสวย ถ่ายรูปได้สวย',
                'comment' => 'มุมไหนก็สวยหมด ถ่ายรูปออกมาสวยทุกมุม แสงสวย บรรยากาศดี เหมาะกับคนชอบถ่ายรูปมากๆ',
                'rating' => 5,
            ],
            [
                'title' => 'ห้องพักสะอาด สะดวกสบาย',
                'comment' => 'ห้องพักสะอาดมาก เตียงนอนสบาย ปรับอากาศได้ดี น้ำร้อนไหลแรง มีอุปกรณ์อำนวยความสะดวกครบครัน',
                'rating' => 5,
            ],
            [
                'title' => 'คุ้มค่ากับเงินที่จ่ายไป',
                'comment' => 'เมื่อเทียบกับราคาที่จ่ายไป รู้สึกว่าคุ้มค่ามากเลยครับ ได้อะไรคืนมาเยอะ ทั้งความสุข ความผ่อนคลาย และประสบการณ์ดีๆ',
                'rating' => 4,
            ],
        ];

        $reviewCount = 0;

        foreach ($destinations->take(8) as $destination) {
            // Random 2-5 reviews per destination
            $numReviews = rand(2, 5);
            $reviewedUsers = $users->random(min($numReviews, $users->count()));

            foreach ($reviewedUsers as $user) {
                $reviewData = $reviewTexts[array_rand($reviewTexts)];

                // Random visit date within last 6 months
                $visitDate = now()->subDays(rand(7, 180));

                Review::create([
                    'user_id' => $user->id,
                    'destination_id' => $destination->id,
                    'rating' => $reviewData['rating'],
                    'title' => $reviewData['title'],
                    'comment' => $reviewData['comment'],
                    'visit_date' => $visitDate,
                    'is_approved' => true,
                    'is_verified_visit' => rand(0, 100) > 30, // 70% verified
                    'is_featured' => rand(0, 100) > 85, // 15% featured
                    'helpful_count' => rand(0, 15),
                    'not_helpful_count' => rand(0, 3),
                    'created_at' => $visitDate->addDays(rand(1, 7)),
                ]);

                $reviewCount++;
            }
        }

        $this->command->info("Created {$reviewCount} reviews for destinations");
    }
}

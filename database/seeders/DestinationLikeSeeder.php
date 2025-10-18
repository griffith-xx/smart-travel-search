<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\DestinationLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class DestinationLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() >= 3) {
            // User 1 - Develop User likes
            $user1Likes = [
                'Yoga Retreat Chiang Mai',
                'Nature Spa Resort',
                'Wellness Resort Phuket',
            ];

            foreach ($user1Likes as $destinationName) {
                $destination = Destination::where('name_en', 'LIKE', '%'.$destinationName.'%')->first();

                if ($destination) {
                    DestinationLike::create([
                        'user_id' => $users[0]->id,
                        'destination_id' => $destination->id,
                    ]);

                    $destination->increment('favorite_count');
                }
            }

            // User 2 - Somchai Wellness likes
            $user2Likes = [
                'Divana Spa',
                'Luxury Spa Phuket',
                'Railay Wellness Spa',
                'Wellness Resort Phuket',
            ];

            foreach ($user2Likes as $destinationName) {
                $destination = Destination::where('name_en', 'LIKE', '%'.$destinationName.'%')->first();

                if ($destination) {
                    DestinationLike::create([
                        'user_id' => $users[1]->id,
                        'destination_id' => $destination->id,
                    ]);

                    $destination->increment('favorite_count');
                }
            }

            // User 3 - Preeda Relax likes
            $user3Likes = [
                'Hin Dad Hot Spring',
                'Yoga Retreat Chiang Mai',
                'Nature Spa Resort',
            ];

            foreach ($user3Likes as $destinationName) {
                $destination = Destination::where('name_en', 'LIKE', '%'.$destinationName.'%')->first();

                if ($destination) {
                    DestinationLike::create([
                        'user_id' => $users[2]->id,
                        'destination_id' => $destination->id,
                    ]);

                    $destination->increment('favorite_count');
                }
            }
        }
    }
}

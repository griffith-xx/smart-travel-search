<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationLike;
use Illuminate\Http\RedirectResponse;

class DestinationLikeController extends Controller
{
    public function toggle(Destination $destination): RedirectResponse
    {
        $user = auth()->user();

        $like = DestinationLike::where('user_id', $user->id)
            ->where('destination_id', $destination->id)
            ->first();

        if ($like) {
            $like->delete();
            $destination->decrement('favorite_count');

            return back();
        }

        DestinationLike::create([
            'user_id' => $user->id,
            'destination_id' => $destination->id,
        ]);

        $destination->increment('favorite_count');

        return back();
    }
}

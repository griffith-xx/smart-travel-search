<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommentLike;
use App\Models\DestinationComment;
use Illuminate\Http\JsonResponse;

class CommentLikeController extends Controller
{
    public function toggle(DestinationComment $comment): JsonResponse
    {
        $user = auth()->user();

        $like = CommentLike::where('user_id', $user->id)
            ->where('comment_id', $comment->id)
            ->first();

        if ($like) {
            $like->delete();
            $comment->decrement('likes_count');

            return response()->json([
                'success' => true,
                'liked' => false,
                'message' => 'ยกเลิกการถูกใจแล้ว',
            ]);
        }

        CommentLike::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        $comment->increment('likes_count');

        return response()->json([
            'success' => true,
            'liked' => true,
            'message' => 'ถูกใจความคิดเห็นแล้ว',
        ]);
    }
}

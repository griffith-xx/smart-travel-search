<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DestinationCommentController extends Controller
{
    public function store(Request $request, Destination $destination): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:destination_comments,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'string',
        ]);

        $comment = DestinationComment::create([
            'user_id' => auth()->id(),
            'destination_id' => $destination->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
            'images' => $validated['images'] ?? null,
            'is_approved' => true,
        ]);

        if ($validated['parent_id'] ?? null) {
            DestinationComment::where('id', $validated['parent_id'])
                ->increment('replies_count');
        }

        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'เพิ่มความคิดเห็นสำเร็จ',
            'comment' => $comment,
        ], 201);
    }

    public function update(Request $request, DestinationComment $comment): JsonResponse
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์แก้ไขความคิดเห็นนี้',
            ], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'string',
        ]);

        $comment->update([
            'content' => $validated['content'],
            'images' => $validated['images'] ?? $comment->images,
            'is_edited' => true,
            'edited_at' => now(),
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขความคิดเห็นสำเร็จ',
            'comment' => $comment,
        ]);
    }

    public function destroy(DestinationComment $comment): JsonResponse
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์ลบความคิดเห็นนี้',
            ], 403);
        }

        if ($comment->parent_id) {
            DestinationComment::where('id', $comment->parent_id)
                ->decrement('replies_count');
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบความคิดเห็นสำเร็จ',
        ]);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    /**
     * Get reviews for a destination.
     */
    public function index(Destination $destination): JsonResponse
    {
        $reviews = Review::where('destination_id', $destination->id)
            ->approved()
            ->with(['user:id,name,profile_photo_path'])
            ->withCount(['helpfulVotes as helpful_votes' => function ($query) {
                $query->where('is_helpful', true);
            }])
            ->withCount(['helpfulVotes as not_helpful_votes' => function ($query) {
                $query->where('is_helpful', false);
            }])
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Add user's vote status to each review
        if (auth()->check()) {
            $reviews->getCollection()->transform(function ($review) {
                $review->user_vote = $review->getUserVote(auth()->id());

                return $review;
            });
        }

        return response()->json($reviews);
    }

    /**
     * Store a new review.
     */
    public function store(Request $request, Destination $destination): JsonResponse
    {
        // Check if user already reviewed this destination
        $existingReview = Review::where('user_id', auth()->id())
            ->where('destination_id', $destination->id)
            ->first();

        if ($existingReview) {
            throw ValidationException::withMessages([
                'destination' => 'คุณได้รีวิวสถานที่นี้แล้ว',
            ]);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:200',
            'comment' => 'required|string|min:10|max:2000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'string',
            'visit_date' => 'nullable|date|before_or_equal:today',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'destination_id' => $destination->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'comment' => $validated['comment'],
            'images' => $validated['images'] ?? null,
            'visit_date' => $validated['visit_date'] ?? null,
            'is_approved' => true,
        ]);

        $review->load('user:id,name,profile_photo_path');

        return response()->json([
            'success' => true,
            'message' => 'เพิ่มรีวิวสำเร็จ',
            'review' => $review,
        ], 201);
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, Review $review): JsonResponse
    {
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์แก้ไขรีวิวนี้',
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:200',
            'comment' => 'required|string|min:10|max:2000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'string',
            'visit_date' => 'nullable|date|before_or_equal:today',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? $review->title,
            'comment' => $validated['comment'],
            'images' => $validated['images'] ?? $review->images,
            'visit_date' => $validated['visit_date'] ?? $review->visit_date,
            'is_edited' => true,
            'edited_at' => now(),
        ]);

        $review->load('user:id,name,profile_photo_path');

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขรีวิวสำเร็จ',
            'review' => $review,
        ]);
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review): JsonResponse
    {
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์ลบรีวิวนี้',
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบรีวิวสำเร็จ',
        ]);
    }

    /**
     * Mark a review as helpful or not helpful.
     */
    public function helpful(Request $request, Review $review): JsonResponse
    {
        $validated = $request->validate([
            'is_helpful' => 'required|boolean',
        ]);

        $userId = auth()->id();

        // Check if user already voted
        $existingVote = $review->helpfulVotes()->where('user_id', $userId)->first();

        if ($existingVote) {
            // If same vote, remove it (toggle)
            if ($existingVote->pivot->is_helpful === $validated['is_helpful']) {
                $review->helpfulVotes()->detach($userId);

                // Decrement count
                if ($validated['is_helpful']) {
                    $review->decrement('helpful_count');
                } else {
                    $review->decrement('not_helpful_count');
                }

                return response()->json([
                    'success' => true,
                    'message' => 'ยกเลิกการโหวต',
                    'user_vote' => null,
                    'helpful_count' => $review->fresh()->helpful_count,
                    'not_helpful_count' => $review->fresh()->not_helpful_count,
                ]);
            } else {
                // Change vote
                $review->helpfulVotes()->updateExistingPivot($userId, [
                    'is_helpful' => $validated['is_helpful'],
                ]);

                // Update counts
                if ($validated['is_helpful']) {
                    $review->increment('helpful_count');
                    $review->decrement('not_helpful_count');
                } else {
                    $review->decrement('helpful_count');
                    $review->increment('not_helpful_count');
                }
            }
        } else {
            // New vote
            $review->helpfulVotes()->attach($userId, [
                'is_helpful' => $validated['is_helpful'],
            ]);

            // Increment count
            if ($validated['is_helpful']) {
                $review->increment('helpful_count');
            } else {
                $review->increment('not_helpful_count');
            }
        }

        return response()->json([
            'success' => true,
            'message' => $validated['is_helpful'] ? 'ขอบคุณสำหรับการโหวต' : 'ขอบคุณสำหรับความคิดเห็น',
            'user_vote' => $validated['is_helpful'],
            'helpful_count' => $review->fresh()->helpful_count,
            'not_helpful_count' => $review->fresh()->not_helpful_count,
        ]);
    }
}

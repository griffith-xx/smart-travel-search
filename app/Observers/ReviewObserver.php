<?php

namespace App\Observers;

use App\Models\Destination;
use App\Models\Review;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        if ($review->is_approved) {
            $this->updateDestinationRating($review->destination_id);
        }
    }

    /**
     * Handle the Review "updated" event.
     */
    public function updated(Review $review): void
    {
        // If approval status changed or rating changed, update destination stats
        if ($review->isDirty(['is_approved', 'rating'])) {
            $this->updateDestinationRating($review->destination_id);
        }
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        if ($review->is_approved) {
            $this->updateDestinationRating($review->destination_id);
        }
    }

    /**
     * Handle the Review "restored" event.
     */
    public function restored(Review $review): void
    {
        if ($review->is_approved) {
            $this->updateDestinationRating($review->destination_id);
        }
    }

    /**
     * Handle the Review "force deleted" event.
     */
    public function forceDeleted(Review $review): void
    {
        $this->updateDestinationRating($review->destination_id);
    }

    /**
     * Update destination's average rating and total reviews count.
     */
    protected function updateDestinationRating(int $destinationId): void
    {
        $destination = Destination::find($destinationId);

        if (! $destination) {
            return;
        }

        // Get all approved reviews for this destination
        $approvedReviews = Review::where('destination_id', $destinationId)
            ->where('is_approved', true)
            ->get();

        $totalReviews = $approvedReviews->count();
        $averageRating = $totalReviews > 0 ? $approvedReviews->avg('rating') : 0;

        // Update destination without triggering events
        $destination->updateQuietly([
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 2),
        ]);
    }
}

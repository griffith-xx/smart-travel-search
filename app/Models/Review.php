<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'destination_id',
        'rating',
        'title',
        'comment',
        'images',
        'visit_date',
        'is_verified_visit',
        'helpful_count',
        'not_helpful_count',
        'is_approved',
        'is_featured',
        'is_edited',
        'edited_at',
        'admin_response',
        'admin_response_at',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'json',
            'visit_date' => 'date',
            'is_verified_visit' => 'boolean',
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
            'is_edited' => 'boolean',
            'edited_at' => 'datetime',
            'admin_response_at' => 'datetime',
        ];
    }

    /**
     * Get the user who wrote this review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the destination this review belongs to.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get the users who found this review helpful.
     */
    public function helpfulVotes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'review_helpful', 'review_id', 'user_id')
            ->withPivot('is_helpful')
            ->withTimestamps();
    }

    /**
     * Scope to get only approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get featured reviews.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get reviews by rating.
     */
    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Check if user has voted this review as helpful.
     */
    public function hasUserVoted(?int $userId): bool
    {
        if (! $userId) {
            return false;
        }

        return $this->helpfulVotes()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's vote for this review.
     */
    public function getUserVote(?int $userId): ?bool
    {
        if (! $userId) {
            return null;
        }

        $vote = $this->helpfulVotes()->where('user_id', $userId)->first();

        return $vote ? $vote->pivot->is_helpful : null;
    }
}

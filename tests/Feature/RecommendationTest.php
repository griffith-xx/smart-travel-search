<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use App\Services\RecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationTest extends TestCase
{
    use RefreshDatabase;

    protected RecommendationService $recommendationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->recommendationService = new RecommendationService;
    }

    public function test_get_popular_destinations_without_authentication(): void
    {
        $response = $this->getJson('/api/recommendations/popular');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit'],
        ]);
    }

    public function test_get_recommendations_requires_authentication(): void
    {
        $response = $this->getJson('/api/recommendations');

        $response->assertStatus(401);
    }

    public function test_get_recommendations_with_authentication(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/recommendations');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit'],
        ]);
    }

    public function test_get_similar_destinations(): void
    {
        // This test will only work if there are destinations in the database
        $destinations = Destination::where('is_active', true)
            ->whereNotNull('published_at')
            ->limit(1)
            ->get();

        if ($destinations->isEmpty()) {
            $this->markTestSkipped('No destinations available for testing');
        }

        $destinationId = $destinations->first()->id;

        $response = $this->getJson("/api/recommendations/similar/{$destinationId}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'destination_id'],
        ]);
    }

    public function test_similar_destinations_returns_404_for_invalid_id(): void
    {
        $response = $this->getJson('/api/recommendations/similar/999999');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Destination not found',
        ]);
    }

    public function test_recommendations_respect_limit_parameter(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/recommendations?limit=5');

        $response->assertStatus(200);
        $response->assertJsonPath('meta.limit', 5);
    }

    public function test_recommendations_limit_max_is_50(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/recommendations?limit=100');

        $response->assertStatus(200);
        $response->assertJsonPath('meta.limit', 50);
    }

    // Popularity-based recommendation tests

    public function test_get_trending_destinations(): void
    {
        $response = $this->getJson('/api/recommendations/trending');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'days'],
        ]);
    }

    public function test_trending_destinations_respect_days_parameter(): void
    {
        $response = $this->getJson('/api/recommendations/trending?days=14');

        $response->assertStatus(200);
        $response->assertJsonPath('meta.days', 14);
    }

    public function test_get_top_rated_destinations(): void
    {
        $response = $this->getJson('/api/recommendations/top-rated');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'min_rating', 'min_reviews'],
        ]);
    }

    public function test_top_rated_destinations_respect_parameters(): void
    {
        $response = $this->getJson('/api/recommendations/top-rated?min_rating=4.5&min_reviews=10');

        $response->assertStatus(200);
        $response->assertJsonPath('meta.min_rating', 4.5);
        $response->assertJsonPath('meta.min_reviews', 10);
    }

    public function test_get_most_favorited_destinations(): void
    {
        $response = $this->getJson('/api/recommendations/most-favorited');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'min_favorites'],
        ]);
    }

    public function test_get_most_viewed_destinations(): void
    {
        $response = $this->getJson('/api/recommendations/most-viewed');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'min_views'],
        ]);
    }

    public function test_get_featured_destinations(): void
    {
        $response = $this->getJson('/api/recommendations/featured');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit'],
        ]);
    }

    public function test_get_editors_picks(): void
    {
        $response = $this->getJson('/api/recommendations/editors-picks');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit'],
        ]);
    }

    public function test_get_popular_by_category(): void
    {
        $response = $this->getJson('/api/recommendations/category/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'category_id'],
        ]);
        $response->assertJsonPath('meta.category_id', 1);
    }

    public function test_get_popular_by_province(): void
    {
        $response = $this->getJson('/api/recommendations/province/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'province_id'],
        ]);
        $response->assertJsonPath('meta.province_id', 1);
    }

    // Collaborative filtering tests

    public function test_get_collaborative_recommendations_requires_authentication(): void
    {
        $response = $this->getJson('/api/recommendations/collaborative');

        $response->assertStatus(401);
    }

    public function test_get_collaborative_recommendations_with_authentication(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/recommendations/collaborative');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'type'],
        ]);
        $response->assertJsonPath('meta.type', 'user-based-collaborative-filtering');
    }

    public function test_get_item_based_recommendations_requires_authentication(): void
    {
        $response = $this->getJson('/api/recommendations/item-based');

        $response->assertStatus(401);
    }

    public function test_get_item_based_recommendations_with_authentication(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/recommendations/item-based');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'type'],
        ]);
        $response->assertJsonPath('meta.type', 'item-based-collaborative-filtering');
    }

    public function test_get_hybrid_recommendations_requires_authentication(): void
    {
        $response = $this->getJson('/api/recommendations/hybrid');

        $response->assertStatus(401);
    }

    public function test_get_hybrid_recommendations_with_authentication(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/recommendations/hybrid');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'type'],
        ]);
        $response->assertJsonPath('meta.type', 'hybrid');
    }

    public function test_get_users_also_liked(): void
    {
        $response = $this->getJson('/api/recommendations/users-also-liked/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['total', 'limit', 'destination_id'],
        ]);
        $response->assertJsonPath('meta.destination_id', 1);
    }
}

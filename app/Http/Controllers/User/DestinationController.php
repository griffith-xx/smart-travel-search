<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Province;
use App\Services\RecommendationService;
use Inertia\Inertia;
use Inertia\Response;

class DestinationController extends Controller
{
    public function __construct(
        protected RecommendationService $recommendationService
    ) {}

    public function index(): Response
    {
        $validated = request()->validate([
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:latest,oldest,name_asc,name_desc,rating_desc,popular,price_asc,price_desc',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0|gte:price_min',
            'rating_min' => 'nullable|numeric|min:0|max:5',
            'provinces' => 'nullable|array',
            'provinces.*' => 'exists:provinces,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'features' => 'nullable|array',
            'features.*' => 'in:parking,wifi,restaurant,pet_friendly,online_booking,featured',
        ]);

        $search = request('search');
        $sort = request('sort', 'latest');

        $query = Destination::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->with(['province', 'category']);

        // Price range filter
        if (request()->filled('price_min')) {
            $query->where(function ($q) {
                $q->where('price_to', '>=', request('price_min'))
                    ->orWhereNull('price_to');
            });
        }

        if (request()->filled('price_max')) {
            $query->where(function ($q) {
                $q->where('price_from', '<=', request('price_max'))
                    ->orWhereNull('price_from');
            });
        }

        // Rating filter
        if (request()->filled('rating_min')) {
            $query->where('average_rating', '>=', request('rating_min'));
        }

        // Province filter (multi-select with OR logic)
        if (request()->filled('provinces') && count(request('provinces')) > 0) {
            $query->whereIn('province_id', request('provinces'));
        }

        // Category filter (multi-select with OR logic)
        if (request()->filled('categories') && count(request('categories')) > 0) {
            $query->whereIn('category_id', request('categories'));
        }

        // Feature filters (AND logic - ต้องมีครบทุกฟีเจอร์ที่เลือก)
        if (request()->filled('features') && count(request('features')) > 0) {
            $featureMap = [
                'parking' => 'has_parking',
                'wifi' => 'has_wifi',
                'restaurant' => 'has_restaurant',
                'pet_friendly' => 'pet_friendly',
                'online_booking' => 'accepts_online_booking',
                'featured' => 'is_featured',
            ];

            foreach (request('features') as $feature) {
                if (isset($featureMap[$feature])) {
                    $query->where($featureMap[$feature], true);
                }
            }
        }

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhereHas('province', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('name_en', 'like', "%{$search}%");
                    });
            });
        }

        // Apply sort
        switch ($sort) {
            case 'oldest':
                $query->orderBy('published_at');
                break;
            case 'name_asc':
                $query->orderBy('name');
                break;
            case 'name_desc':
                $query->orderByDesc('name');
                break;
            case 'rating_desc':
                $query->orderByDesc('average_rating');
                break;
            case 'popular':
                $query->orderByDesc('view_count')
                    ->orderByDesc('favorite_count');
                break;
            case 'price_asc':
                $query->orderBy('price_from');
                break;
            case 'price_desc':
                $query->orderByDesc('price_from');
                break;
            case 'latest':
            default:
                $query->orderByDesc('published_at');
                break;
        }

        $destinations = $query->paginate(15)->withQueryString();

        return Inertia::render('User/Destinations/Index', [
            'destinations' => $destinations,
            'filters' => [
                'search' => $search,
                'sort' => $sort,
                'price_min' => request('price_min'),
                'price_max' => request('price_max'),
                'rating_min' => request('rating_min'),
                'provinces' => request('provinces') ?? [],
                'categories' => request('categories') ?? [],
                'features' => request('features') ?? [],
            ],
            'filterOptions' => [
                'provinces' => Province::orderBy('name')
                    ->get(['id', 'name', 'name_en']),
                'categories' => Category::orderBy('name')
                    ->get(['id', 'name', 'name_en']),
                'priceRange' => [
                    'min' => 0,
                    'max' => Destination::where('is_active', true)
                        ->max('price_to') ?? 10000,
                ],
            ],
        ]);
    }

    public function recommended(): Response
    {
        $user = auth()->user();

        if (! $user || ! $user->preference) {
            return redirect()->route('destinations.index')
                ->with('message', 'กรุณากรอกความชอบของคุณเพื่อรับคำแนะนำสถานที่');
        }

        $recommendations = $this->recommendationService
            ->getHybridRecommendations($user, 20);

        return Inertia::render('User/Destinations/Recommended', [
            'recommendations' => $recommendations,
        ]);
    }

    public function saved(): Response
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $savedDestinations = $user->likedDestinations()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->with(['province', 'category'])
            ->orderByDesc('destination_likes.created_at')
            ->paginate(12);

        return Inertia::render('User/Destinations/Saved', [
            'destinations' => $savedDestinations,
        ]);
    }

    public function show(string $slug): Response
    {
        $user = auth()->user();

        $destination = Destination::where('slug', $slug)
            ->with(['province', 'category'])
            ->firstOrFail();

        // Increment view count
        $destination->increment('view_count');

        // Load comments with user and likes information
        $comments = $destination->comments()
            ->whereNull('parent_id')
            ->with([
                'user',
                'replies.user',
                'replies.likes' => function ($query) use ($user) {
                    if ($user) {
                        $query->where('user_id', $user->id);
                    }
                },
                'likes' => function ($query) use ($user) {
                    if ($user) {
                        $query->where('user_id', $user->id);
                    }
                },
            ])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'images' => $comment->images,
                    'likes_count' => $comment->likes_count,
                    'replies_count' => $comment->replies_count,
                    'is_edited' => $comment->is_edited,
                    'edited_at' => $comment->edited_at,
                    'created_at' => $comment->created_at,
                    'user' => $comment->user,
                    'is_liked' => $comment->likes->isNotEmpty(),
                    'replies' => $comment->replies->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'likes_count' => $reply->likes_count,
                            'is_edited' => $reply->is_edited,
                            'edited_at' => $reply->edited_at,
                            'created_at' => $reply->created_at,
                            'user' => $reply->user,
                            'is_liked' => $reply->likes->isNotEmpty(),
                        ];
                    }),
                ];
            });

        // Check if user has liked this destination
        $isLiked = false;
        $likeCount = $destination->favorite_count ?? 0;

        if ($user) {
            $isLiked = $destination->likes()->where('user_id', $user->id)->exists();
        }

        return Inertia::render('User/Destinations/Show', [
            'destination' => array_merge($destination->toArray(), [
                'is_liked' => $isLiked,
                'like_count' => $likeCount,
            ]),
            'comments' => $comments,
        ]);
    }
}

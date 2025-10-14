<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Destination extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // Basic Information
        'province_id',
        'name',
        'slug',
        'name_en',
        'short_description',
        'description',

        // Location & Contact
        'latitude',
        'longitude',
        'address',
        'district',
        'subdistrict',
        'postal_code',
        'phone',
        'email',
        'website',
        'line_id',
        'facebook',
        'instagram',

        // Media
        'cover_image',
        'gallery_images',
        'video_url',
        'virtual_tour_url',

        // Pricing & Booking
        'price_from',
        'price_to',
        'currency',
        'pricing_note',
        'accepts_online_booking',
        'booking_url',

        // Ratings & Reviews
        'average_rating',
        'total_reviews',
        'total_bookings',
        'view_count',
        'favorite_count',

        // SEO & Marketing
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',

        // Special Features
        'has_parking',
        'has_wifi',
        'has_restaurant',
        'pet_friendly',

        // Admin & Status
        'is_active',
        'is_featured',
        'is_recommended',
        'sort_order',
        'admin_notes',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        // Basic Information
        'province_id' => 'integer',

        // Location & Contact
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',

        // Media
        'gallery_images' => 'array',

        // Pricing & Booking
        'price_from' => 'decimal:2',
        'price_to' => 'decimal:2',
        'accepts_online_booking' => 'boolean',

        // Ratings & Reviews
        'average_rating' => 'decimal:2',
        'total_reviews' => 'integer',
        'total_bookings' => 'integer',
        'view_count' => 'integer',
        'favorite_count' => 'integer',

        // SEO & Marketing
        'meta_keywords' => 'array',

        // Special Features
        'has_parking' => 'boolean',
        'has_wifi' => 'boolean',
        'has_restaurant' => 'boolean',
        'pet_friendly' => 'boolean',
        'wheelchair_accessible' => 'boolean',
        'family_friendly' => 'boolean',
        'eco_friendly' => 'boolean',

        // Admin & Status
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_recommended' => 'boolean',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected $appends = ['gallery_images_array'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = $destination->generateSlug();
            }

            static::created(function ($destination) {
                $destination->preference()->create([]);
            });
        });

        static::updating(function ($destination) {
            if ($destination->isDirty('name_en') || $destination->isDirty('name')) {
                if (empty($destination->slug) || $destination->isDirty('name_en')) {
                    $destination->slug = $destination->generateSlug();
                }
            }
        });
    }

    /**
     * Get the preferences for the destination.
     */
    public function preference(): HasOne
    {
        return $this->hasOne(DestinationPreference::class);
    }


    /**
     * Get the province that owns the destination.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the admin who created this destination.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get the admin who last updated this destination.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function generateSlug(): string
    {
        $slug = \Illuminate\Support\Str::slug($this->name_en ?? $this->name);

        $count = static::where('slug', 'LIKE', "{$slug}%")
            ->where('id', '!=', $this->id ?? 0)
            ->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }

    public function getGalleryImagesArrayAttribute()
    {
        if (is_string($this->gallery_images)) {
            return json_decode($this->gallery_images, true) ?? [];
        }

        return $this->gallery_images ?? [];
    }
}

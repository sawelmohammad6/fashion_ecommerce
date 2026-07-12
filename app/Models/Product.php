<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'brand',
        'description',
        'full_description',
        'fabric',
        'color',
        'print',
        'size',
        'price',
        'buying_price',
        'discount_price',
        'discount_type',
        'stock',
        'sku',
        'barcode',
        'image',
        'gallery_images',
        'video_url',
        'variations',
        'featured',
        'status',
        'pre_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'variations' => 'array',
            'featured' => 'boolean',
            'status' => 'boolean',
            'pre_order' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_id', 'attribute_value_id')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }

    public function getFinalPriceAttribute(): float
    {
        if ($this->discount_price) {
            if ($this->discount_type === 'percentage') {
                return round($this->price - ($this->price * $this->discount_price / 100), 2);
            }
            return $this->discount_price;
        }
        return $this->price;
    }

    public function getAvgRatingAttribute(): float
    {
        return round($this->reviews()->where('status', true)->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->where('status', true)->count();
    }

    public function isInWishlist(?int $userId = null): bool
    {
        if (! $userId) {
            return false;
        }

        return $this->wishlists()->where('user_id', $userId)->exists();
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeLowStock($query, int $threshold = 5)
    {
        return $query->where('stock', '>', 0)->where('stock', '<=', $threshold);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeMatchSort($query, string $sort)
    {
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc' => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };
    }
}

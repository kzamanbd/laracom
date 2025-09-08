<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, SoftDeletes;
    protected $casts = [
        'attributes' => 'array',
        'meta' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'model')->whereNot('collection', 'thumbnail');
    }

    /**
     * Get the first thumbnail image
     */
    public function thumbnail()
    {
        return $this->morphOne(Media::class, 'model')->where('collection', 'thumbnail');
    }

    public function getThumbnailPathAttribute()
    {
        // Try to get from loaded relationship first to avoid N+1
        if ($this->relationLoaded('thumbnail')) {
            return $this->thumbnail?->file_path;
        }

        // Fallback to direct query if relationship not loaded
        static $thumbnailCache = [];
        $cacheKey = $this->id;

        if (!isset($thumbnailCache[$cacheKey])) {
            $thumbnail = $this->images()->where('collection', 'thumbnail')->first();
            $thumbnailCache[$cacheKey] = $thumbnail?->file_path;
        }

        return $thumbnailCache[$cacheKey];
    }

    public function reviews()
    {
        return $this->morphMany(Comment::class, 'model');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

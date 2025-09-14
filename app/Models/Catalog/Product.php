<?php

namespace App\Models\Catalog;

use App\Models\Content\Comment;
use App\Models\Content\Media;
use App\Models\Content\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, SoftDeletes;

    protected $casts = [
        'attributes' => 'array',
        'meta' => 'array',
    ];

    protected $appends = ['thumbnail_path'];

    /**
     * Get the user that owns this product (vendor)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'model')
            ->whereNot('collection', 'thumbnail');
    }

    /**
     * Get the first thumbnail image
     */
    public function thumbnail()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection', 'thumbnail')
            ->withDefault();
    }

    public function getThumbnailPathAttribute(): ?string
    {
        return $this->thumbnail->file_path;
    }

    public function getRouteKeyAttribute(): string
    {
        return $this->slug ?? $this->id;
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

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
        return $this->morphMany(Media::class, 'model');
    }

    public function getThumbnailAttribute()
    {
        $thumbnail = $this->images()->where('collection', 'thumbnail')->first();
        if ($thumbnail) {
            return $thumbnail->file_path;
        }
        return null;
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

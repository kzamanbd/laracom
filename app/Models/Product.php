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

    protected $appends = ['feature_image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function getFeatureImageAttribute()
    {
        return $this->images()->where('collection', 'product_feature')->first();
    }
}

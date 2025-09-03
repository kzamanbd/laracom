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
        return $this->belongsToMany(\App\Models\Category::class, 'category_product');
    }
}

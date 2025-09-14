<?php

namespace App\Models\Content;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\Content\TagFactory> */
    use HasFactory;

    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}

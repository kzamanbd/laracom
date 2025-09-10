<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class ProductService
{
    /**
     * Fetch products for the shop page.
     * You can add filters, sorting, pagination, etc. here.
     */
    public function getShopProducts($args)
    {
        $perPage = $args['limit'] ?? 15;
        $orderby = $args['sort'] ?? 'newest';
        $orderDir = $args['order'] ?? 'desc';

        $supportedSorts = [
            'name' => 'name',
            'price' => 'price',
            'newest' => 'created_at',
        ];

        return Product::query()
            ->with([
                'categories',
                'thumbnail',
            ])
            ->when(array_key_exists($orderby, $supportedSorts), function ($query) use ($orderby, $orderDir, $supportedSorts) {
                $query->orderBy($supportedSorts[$orderby], $orderDir);
            })
            ->paginate($perPage);
    }

    public function getFeaturedProducts($limit = 8)
    {
        return Product::query()
            ->with(['categories', 'thumbnail'])
            // Todo: Add a boolean field 'is_featured' in products table
            // ->where('is_featured', true)
            ->take($limit)
            ->inRandomOrder()
            ->get();
    }

    public function getNewArrivals($limit = 8)
    {
        return Product::query()
            ->with(['categories', 'thumbnail'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getPopularProducts($limit = 8)
    {
        return Product::query()
            ->with(['categories', 'thumbnail'])
            // Todo: Add a boolean field 'is_popular' in products table
            // ->orderBy('is_popular', 'desc')
            ->take($limit)
            ->inRandomOrder()
            ->get();
    }

    public function getPopularCategories($limit = 10)
    {
        // Assuming you have a Category model with a 'products' relationship
        return Category::query()
            ->with(['image'])
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take($limit)
            ->get();
    }
}

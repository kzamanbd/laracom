<?php

namespace App\Services\Product;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;

class ProductService
{
    /**
     * Fetch products for the shop page.
     * You can add filters, sorting, pagination, etc. here.
     */
    public function getShopProducts($args)
    {
        $defaultArgs = [
            'limit' => 15,
            'sort' => 'newest',
            'order' => 'desc',
            'categories' => '',
            'minPrice' => 0,
            'maxPrice' => 1000,
            'colors' => '',
            'conditions' => '',
        ];
        $args = array_merge($defaultArgs, $args);

        $query = Product::query()
            ->with([
                'categories',
                'thumbnail',
            ]);

        // Apply category filters
        if (! empty($args['categories'])) {
            $query->whereHas('categories', function ($q) use ($args) {
                $q->whereIn('categories.slug', explode(',', $args['categories']));
            });
        }

        // Apply price range filters
        if (! empty($args['minPrice']) && is_numeric($args['minPrice'])) {
            $query->where('price', '>=', $args['minPrice']);
        }

        if (! empty($args['maxPrice']) && is_numeric($args['maxPrice'])) {
            $query->where('price', '<=', $args['maxPrice']);
        }

        // Apply color filters
        if (! empty($args['colors'])) {
            $query->where(function ($q) use ($args) {
                foreach (explode(',', $args['colors']) as $color) {
                    $q->orWhereJsonContains('attributes->color', $color);
                }
            });
        }

        // Apply condition filters
        if (! empty($args['conditions'])) {
            $query->where(function ($q) use ($args) {
                foreach (explode(',', $args['conditions']) as $condition) {
                    $q->orWhereJsonContains('attributes->condition', $condition);
                }
            });
        }

        $supportedSortOrder = [
            'name' => 'name',
            'price' => 'price',
            'newest' => 'created_at',
        ];

        // Apply sorting
        $query->when(array_key_exists($args['sort'], $supportedSortOrder), function ($query) use ($args, $supportedSortOrder) {
            $query->orderBy($supportedSortOrder[$args['sort']], $args['order']);
        });

        return $query->paginate($args['limit']);
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

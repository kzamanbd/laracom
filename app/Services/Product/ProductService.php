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
            'filters' => [],
        ];
        $args = array_merge($defaultArgs, $args);

        $orderDir = $args['order'];
        $filters = $args['filters'];

        $query = Product::query()
            ->with([
                'categories',
                'thumbnail',
            ]);

        // Apply category filters
        if (! empty($filters['categories'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->whereIn('categories.slug', explode(',', $filters['categories']));
            });
        }

        // Apply price range filters
        if (! empty($filters['minPrice']) && is_numeric($filters['minPrice'])) {
            $query->where('price', '>=', $filters['minPrice']);
        }

        if (! empty($filters['maxPrice']) && is_numeric($filters['maxPrice'])) {
            $query->where('price', '<=', $filters['maxPrice']);
        }

        // Apply color filters
        if (! empty($filters['colors'])) {
            $query->where(function ($q) use ($filters) {
                foreach (explode(',', $filters['colors']) as $color) {
                    $q->orWhereJsonContains('attributes->color', $color);
                }
            });
        }

        // Apply condition filters
        if (! empty($filters['conditions'])) {
            $query->where(function ($q) use ($filters) {
                foreach (explode(',', $filters['conditions']) as $condition) {
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

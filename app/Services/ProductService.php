<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * Fetch products for the shop page.
     * You can add filters, sorting, pagination, etc. here.
     */
    public function getShopProducts($perPage = 10)
    {
        return Product::query()
            ->with([
                'categories',
                'thumbnail',
                'images',
            ])
            ->inRandomOrder()
            ->paginate($perPage);
    }
}

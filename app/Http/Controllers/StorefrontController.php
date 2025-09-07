<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Http\Requests\ShopProductRequest;

class StorefrontController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function shop(ShopProductRequest $request)
    {
        // You can use $request->validated() for filters, sorting, etc.
        $products = $this->productService->getShopProducts(12);
        // dd($products);
        return view('storefront.shop', compact('products'));
    }
}

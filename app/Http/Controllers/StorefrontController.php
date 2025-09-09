<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopProductRequest;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function __construct(public ProductService $productService) {}

    public function index(): View
    {
        $featuredProducts = $this->productService->getFeaturedProducts(8);
        $popularProducts = $this->productService->getPopularProducts(8);
        $newArrivals = $this->productService->getNewArrivals(8);
        $popularCategories = $this->productService->getPopularCategories(10);

        return view('storefront.home', [
            'featuredProducts' => $featuredProducts,
            'popularProducts' => $popularProducts,
            'newArrivals' => $newArrivals,
            'popularCategories' => $popularCategories,
        ]);
    }

    public function shop(ShopProductRequest $request): View
    {
        // You can use $request->validated() for filters, sorting, etc.
        $products = $this->productService->getShopProducts(12);

        return view('storefront.shop', compact('products'));
    }

    public function cart(): View
    {
        return view('storefront.cart');
    }

    public function cartClear(CartService $cartService): void
    {
        $cartService->clearCart();
    }
}

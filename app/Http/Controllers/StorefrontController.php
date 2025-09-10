<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
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
        $promotions = Promotion::current()->ordered()->with('image')->get();

        return view('storefront.home', [
            'featuredProducts' => $featuredProducts,
            'popularProducts' => $popularProducts,
            'newArrivals' => $newArrivals,
            'popularCategories' => $popularCategories,
            'promotions' => $promotions,
        ]);
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

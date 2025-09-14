<?php

namespace App\Livewire\Storefront\Product;

use App\Livewire\Storefront\Cart\CartBase;
use App\Models\Catalog\Product;
use App\Services\Cart\WishlistService;

class Card extends CartBase
{
    public Product $product;

    public $class = 'col-lg-4 col-md-4 col-6 col-sm-6';

    public $addToCartText = 'Add To Cart';

    public $addToWishlistText = 'Add To Wishlist';

    public function addToCart(): void
    {
        $this->getCartService()->addToCart($this->product->id);
        $this->dispatchCartUpdated('Product added to cart successfully!');
        $this->addToCartText = 'Added';
    }

    public function addToWishlist(): void
    {
        if (! auth()->check()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Please login to add items to wishlist.',
            ]);

            return;
        }
        app(WishlistService::class)->addToWishlist(auth()->user(), $this->product->id);
        $this->dispatchCartUpdated('Product added to wishlist successfully!');
        $this->addToWishlistText = 'Added';
    }

    public function quickView(): void
    {
        $this->dispatch('quick-view', $this->product);
    }

    public function render()
    {
        return view('livewire.storefront.product.card');
    }
}

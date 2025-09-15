<?php

namespace App\Livewire\Storefront\Cart\Wishlist;

use App\Models\Cart\Wishlist;
use App\Models\Catalog\Product;
use App\Services\Cart\CartService;
use App\Services\Cart\WishlistService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.storefront', ['title' => 'My Wishlist'])]
class WishlistPage extends Component
{
    public $wishlistItems = [];

    public function mount(): void
    {
        $this->loadWishlistItems();
    }

    #[On('wishlist-updated')]
    public function loadWishlistItems(): void
    {
        if (! Auth::check()) {
            $this->wishlistItems = [];

            return;
        }

        $wishlistService = app(WishlistService::class);
        $this->wishlistItems = $wishlistService->getWishlistItems(Auth::user());
    }

    public function removeFromWishlist(int $itemId): void
    {
        if (! Auth::check()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Please login to manage your wishlist.',
            ]);

            return;
        }

        $item = Wishlist::where('id', $itemId)
            ->where('user_id', Auth::id())
            ->first();

        if ($item) {
            $wishlistService = app(WishlistService::class);
            $success = $wishlistService->removeFromWishlist(Auth::user(), $item->product_id);

            if ($success) {
                $this->loadWishlistItems();
                $this->dispatch('toast', [
                    'type' => 'success',
                    'message' => 'Item removed from wishlist successfully!',
                ]);
            } else {
                $this->dispatch('toast', [
                    'type' => 'error',
                    'message' => 'Failed to remove item from wishlist.',
                ]);
            }
        }
    }

    public function addToCart(int $productId): void
    {
        if (! Auth::check()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Please login to add items to cart.',
            ]);

            return;
        }

        $cartService = app(CartService::class);
        $product = Product::find($productId);

        if ($product) {
            $cartService->addToCart($productId);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Product added to cart successfully!',
            ]);
            $this->dispatch('cart-updated');
        }
    }

    public function addAllToCart(): void
    {
        if (! Auth::check()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Please login to add items to cart.',
            ]);

            return;
        }

        $cartService = app(CartService::class);
        $addedCount = 0;

        foreach ($this->wishlistItems as $item) {
            $product = Product::find($item['product']['id']);
            if ($product && $product->quantity > 0) {
                $cartService->addToCart($product->id);
                $addedCount++;
            }
        }

        if ($addedCount > 0) {
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "{$addedCount} ".($addedCount === 1 ? 'item' : 'items').' added to cart successfully!',
            ]);
            $this->dispatch('cart-updated');
        } else {
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => 'No available items to add to cart.',
            ]);
        }
    }

    public function clearWishlist(): void
    {
        if (! Auth::check()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Please login to manage your wishlist.',
            ]);

            return;
        }

        $wishlistService = app(WishlistService::class);
        $success = $wishlistService->clearWishlist(Auth::user());

        if ($success) {
            $this->loadWishlistItems();
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Wishlist cleared successfully!',
            ]);
            $this->dispatch('wishlist-updated');
        } else {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Failed to clear wishlist.',
            ]);
        }
    }

    public function getItemCountProperty(): int
    {
        return count($this->wishlistItems);
    }

    public function render()
    {
        return view('livewire.storefront.cart.wishlist.wishlist-page');
    }
}

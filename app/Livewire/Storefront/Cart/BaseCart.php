<?php

namespace App\Livewire\Storefront\Cart;

use App\Models\Cart;
use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class BaseCart extends Component
{
    /**
     * Get the cart service instance
     */
    public function getCartService(): CartService
    {
        return app(CartService::class);
    }

    /**
     * Get the current cart
     */

    public function cart(): Cart
    {
        return $this->getCartService()->getCurrentCart()
            ->load(['items.product.thumbnail']);
    }

    /**
     * Dispatch cart updated events and show success message
     */
    public function dispatchCartUpdated(string $message = 'Cart updated successfully!'): void
    {
        $this->dispatch('cart-updated');
        session()->flash('cart_message', $message);
    }

    /**
     * Get product thumbnail URL with fallback
     */
    public function getProductThumbnail($product): string
    {
        return $product->thumbnail_path;
    }

    /**
     * Get product URL using slug or ID
     */
    public function getProductUrl($product): string
    {
        return route('product', $product->slug ?? $product->id);
    }

    /**
     * Remove item from cart with standard messaging
     */
    public function removeItem(int $cartItemId): void
    {
        $this->getCartService()->removeFromCart($cartItemId);
        $this->dispatchCartUpdated('Item removed from cart successfully!');
    }

    /**
     * Standard cart refresh method for computed properties
     */
    #[On('cart-updated')]
    public function refreshCart(): void
    {
        // Force recomputation of cart-related computed properties
        if (property_exists($this, 'cart')) {
            unset($this->cart);
        }
        if (property_exists($this, 'itemCount')) {
            unset($this->itemCount);
        }
    }
}

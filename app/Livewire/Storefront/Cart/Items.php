<?php

namespace App\Livewire\Storefront\Cart;

use App\Models\CartItem;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

class Items extends CartComponentBase
{
    public bool $updating = false;

    #[Computed]
    public function cartItems(): Collection
    {
        return $this->getCartService()->getCurrentCart()->items()->with('product.thumbnail')->get();
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(int $cartItemId, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeItem($cartItemId);

            return;
        }

        $this->updating = true;

        $this->getCartService()->updateCartItem($cartItemId, $quantity);

        // Dispatch events to update other cart components
        $this->dispatchCartUpdated();

        $this->updating = false;
    }

    /**
     * Increase quantity by 1
     */
    public function incrementQuantity(int $cartItemId): void
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $this->updateQuantity($cartItemId, $cartItem->quantity + 1);
    }

    /**
     * Decrease quantity by 1
     */
    public function decrementQuantity(int $cartItemId): void
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $this->updateQuantity($cartItemId, max(1, $cartItem->quantity - 1));
    }

    /**
     * Get item subtotal
     */
    public function getSubtotal(CartItem $cartItem): string
    {
        return formatPrice($cartItem->quantity * $cartItem->unit_price);
    }

    /**
     * Clear all items from cart
     */
    public function clearCart(): void
    {
        $this->getCartService()->clearCart();
        $this->dispatchCartUpdated('Cart cleared successfully!');
    }

    public function render()
    {
        return view('livewire.storefront.cart.items');
    }
}

<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Catalog\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get the current cart for the session/user
     */
    public function getCurrentCart(): Cart
    {
        $cart = null;

        // Try to get cart for authenticated user first
        if (auth()->check()) {
            $cart = Cart::query()->where('user_id', auth()->id())
                ->active()
                ->first();

            // If user just logged in, try to merge session cart
            if (! $cart) {
                $cart = $this->mergeSessionCartForUser(auth()->user());
            }
        }

        // If no user cart, get session cart
        if (! $cart) {
            $sessionId = Session::getId();
            $cart = Cart::query()->where('session_id', $sessionId)
                ->active()
                ->first();
        }

        // Create new cart if none exists
        if (! $cart) {
            $cart = $this->createCart();
        }

        return $cart;
    }

    /**
     * Create a new cart
     */
    public function createCart(): Cart
    {
        $data = [
            'currency' => 'USD',
            'status' => 'active',
            'last_activity_at' => now(),
            'expires_at' => now()->addDays(30), // Default 30 days expiry
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();

            // Check for existing converted cart for this user and reactivate it
            $existingCart = Cart::where('user_id', auth()->id())
                ->whereIn('status', ['converted', 'abandoned'])
                ->first();

            if ($existingCart) {
                $existingCart->update([
                    'status' => 'active',
                    'last_activity_at' => now(),
                    'expires_at' => now()->addDays(30),
                    'subtotal' => 0,
                    'discount_total' => 0,
                    'tax_total' => 0,
                    'shipping_total' => 0,
                    'total' => 0,
                    'coupon_code' => null,
                    'coupon_discount' => 0,
                ]);

                // Clear any existing items
                $existingCart->items()->delete();

                return $existingCart;
            }
        } else {
            $sessionId = Session::getId();
            $data['session_id'] = $sessionId;

            // Check for existing converted cart for this session and reactivate it
            $existingCart = Cart::where('session_id', $sessionId)
                ->whereIn('status', ['converted', 'abandoned'])
                ->first();

            if ($existingCart) {
                $existingCart->update([
                    'status' => 'active',
                    'last_activity_at' => now(),
                    'expires_at' => now()->addDays(30),
                    'subtotal' => 0,
                    'discount_total' => 0,
                    'tax_total' => 0,
                    'shipping_total' => 0,
                    'total' => 0,
                    'coupon_code' => null,
                    'coupon_discount' => 0,
                ]);

                // Clear any existing items
                $existingCart->items()->delete();

                return $existingCart;
            }
        }

        return Cart::create($data);
    }

    /**
     * Add product to cart
     */
    public function addToCart(
        int $productId,
        int $quantity = 1,
        ?array $attributes = null,
        ?array $meta = null
    ): CartItem {
        $cart = $this->getCurrentCart();
        $product = Product::findOrFail($productId);

        // Check if item already exists with same attributes
        /* @var CartItem|null $existingItem */
        $existingItem = $cart->items()
            ->where('product_id', $productId)
            ->where('product_attributes', $attributes)
            ->first();

        if ($existingItem) {
            $existingItem->updateQuantity($existingItem->quantity + $quantity);

            return $existingItem;
        }

        // Create new cart item
        $unitPrice = $product->sale_price ?? $product->price;

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'currency' => $cart->currency,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'product_attributes' => $attributes,
            'tax_id' => $product->tax_id,
            'tax_rate' => $product->tax?->rate ?? 0,
            'meta' => $meta,
        ]);

        return $cartItem;
    }

    /**
     * Update cart item quantity
     */
    public function updateCartItem(int $cartItemId, int $quantity): ?CartItem
    {
        $cart = $this->getCurrentCart();
        /* @var CartItem|null $cartItem */
        $cartItem = $cart->items()->find($cartItemId);

        if (! $cartItem) {
            return null;
        }

        $cartItem->updateQuantity($quantity);

        return $cartItem;
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(int $cartItemId): bool
    {
        $cart = $this->getCurrentCart();
        $cartItem = $cart->items()->find($cartItemId);

        if (! $cartItem) {
            return false;
        }

        $cartItem->delete();

        return true;
    }

    /**
     * Clear all items from cart
     */
    public function clearCart(): void
    {
        $cart = $this->getCurrentCart();
        $cart->items()->delete();
        $cart->updateTotals();
    }

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(string $couponCode): bool
    {
        $cart = $this->getCurrentCart();

        // Here you would validate the coupon and calculate discount
        // This is a simplified example
        $discount = $this->calculateCouponDiscount($couponCode, (float) $cart->subtotal);

        if ($discount > 0) {
            $cart->update([
                'coupon_code' => $couponCode,
                'coupon_discount' => $discount,
            ]);
            $cart->updateTotals();

            return true;
        }

        return false;
    }

    /**
     * Remove coupon from cart
     */
    public function removeCoupon(): void
    {
        $cart = $this->getCurrentCart();
        $cart->update([
            'coupon_code' => null,
            'coupon_discount' => 0,
        ]);
        $cart->updateTotals();
    }

    /**
     * Convert cart to order (simplified)
     */
    public function convertToOrder(array $orderData = []): bool
    {
        $cart = $this->getCurrentCart();

        if ($cart->isEmpty()) {
            return false;
        }

        // Here you would create an order from the cart
        // This is where you'd integrate with your order creation logic

        $cart->markAsConverted();

        return true;
    }

    /**
     * Merge session cart when user logs in
     */
    protected function mergeSessionCartForUser(User $user): ?Cart
    {
        $sessionId = Session::getId();
        $sessionCart = Cart::query()->where('session_id', $sessionId)
            ->active()
            ->first();

        if (! $sessionCart || $sessionCart->isEmpty()) {
            return null;
        }

        // Create user cart or get existing
        $userCart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active'],
            [
                'currency' => $sessionCart->currency,
                'status' => 'active',
                'last_activity_at' => now(),
                'expires_at' => now()->addDays(30), // Default 30 days
            ]
        );

        // Move items from session cart to user cart
        foreach ($sessionCart->items as $item) {
            $existingItem = $userCart->items()
                ->where('product_id', $item->product_id)
                ->where('product_attributes', $item->product_attributes)
                ->first();

            if ($existingItem) {
                $existingItem->updateQuantity($existingItem->quantity + $item->quantity);
            } else {
                $item->update(['cart_id' => $userCart->id]);
            }
        }

        // Delete session cart
        $sessionCart->delete();

        return $userCart;
    }

    /**
     * Calculate coupon discount (simplified)
     */
    protected function calculateCouponDiscount(string $couponCode, float $subtotal): float
    {
        // This is a simplified example
        // In a real application, you'd have a coupons table and validation logic
        $coupons = [
            'SAVE10' => 0.10, // 10% discount
            'SAVE20' => 0.20, // 20% discount
            'FLAT5' => 5.00,  // $5 flat discount
        ];

        if (isset($coupons[$couponCode])) {
            $discount = $coupons[$couponCode];

            if ($discount < 1) {
                // Percentage discount
                return $subtotal * $discount;
            } else {
                // Flat discount
                return min($discount, $subtotal);
            }
        }

        return 0;
    }

    /**
     * Get cart item count
     */
    public function getCartItemCount(): int
    {
        $cart = $this->getCurrentCart();

        return $cart->item_count;
    }

    /**
     * Clean up expired carts
     */
    public static function cleanupExpiredCarts(): int
    {
        return Cart::cleanupExpired();
    }
}

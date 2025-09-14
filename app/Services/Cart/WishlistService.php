<?php

namespace App\Services\Cart;

use App\Models\Cart\Wishlist;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WishlistService
{
    public function addToWishlist(User $user, int $productId): bool
    {
        try {
            $existing = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                return false; // Already in wishlist
            }

            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function removeFromWishlist(User $user, int $productId): bool
    {
        try {
            $deleted = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();

            return $deleted > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function hasInWishlist(User $user, int $productId): bool
    {
        return Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();
    }

    public function getWishlistItems(User $user)
    {
        return Wishlist::where('user_id', $user->id)
            ->with(['product.thumbnail', 'product.categories'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getWishlistCount(User $user): int
    {
        return Wishlist::where('user_id', $user->id)->count();
    }

    public function clearWishlist(User $user): bool
    {
        try {
            Wishlist::where('user_id', $user->id)->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function moveToCart(User $user, int $productId): bool
    {
        try {
            DB::beginTransaction();

            // Check if product exists and is in wishlist
            $wishlistItem = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if (! $wishlistItem) {
                return false;
            }

            // Add to cart using CartService
            $cartService = app(CartService::class);
            $cartService->addToCart($productId);

            // Remove from wishlist
            $this->removeFromWishlist($user, $productId);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function moveAllToCart(User $user): array
    {
        $results = ['success' => 0, 'failed' => 0];

        $wishlistItems = $this->getWishlistItems($user);

        foreach ($wishlistItems as $item) {
            if ($this->moveToCart($user, $item->product_id)) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }
}

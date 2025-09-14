<?php

use App\Livewire\Storefront\Cart\Wishlist\WishlistPage;
use App\Models\Cart\Wishlist;
use App\Models\Catalog\Product;
use App\Models\User;
use App\Services\Cart\WishlistService;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'customer']);
    $this->vendor = User::factory()->create(['role' => 'vendor']);
    $this->product = Product::factory()->create(['user_id' => $this->vendor->id]);
    $this->wishlistService = app(WishlistService::class);
});

describe('WishlistService', function () {
    it('can add product to wishlist', function () {
        $result = $this->wishlistService->addToWishlist($this->user, $this->product->id);

        expect($result)->toBeTrue();
        expect(Wishlist::where('user_id', $this->user->id)
            ->where('product_id', $this->product->id)
            ->exists())->toBeTrue();
    });

    it('cannot add duplicate product to wishlist', function () {
        $this->wishlistService->addToWishlist($this->user, $this->product->id);
        $result = $this->wishlistService->addToWishlist($this->user, $this->product->id);

        expect($result)->toBeFalse();
        expect(Wishlist::where('user_id', $this->user->id)
            ->where('product_id', $this->product->id)
            ->count())->toBe(1);
    });

    it('can remove product from wishlist', function () {
        $this->wishlistService->addToWishlist($this->user, $this->product->id);
        $result = $this->wishlistService->removeFromWishlist($this->user, $this->product->id);

        expect($result)->toBeTrue();
        expect(Wishlist::where('user_id', $this->user->id)
            ->where('product_id', $this->product->id)
            ->exists())->toBeFalse();
    });

    it('can check if product is in wishlist', function () {
        expect($this->wishlistService->hasInWishlist($this->user, $this->product->id))->toBeFalse();

        $this->wishlistService->addToWishlist($this->user, $this->product->id);

        expect($this->wishlistService->hasInWishlist($this->user, $this->product->id))->toBeTrue();
    });
});

describe('WishlistPage Component', function () {
    it('loads wishlist items for authenticated user', function () {
        $this->actingAs($this->user);
        $this->wishlistService->addToWishlist($this->user, $this->product->id);

        Livewire::test(WishlistPage::class)
            ->assertSet('wishlistItems', function ($items) {
                return count($items) === 1;
            });
    });

    it('shows empty wishlist for unauthenticated user', function () {
        Livewire::test(WishlistPage::class)
            ->assertSet('wishlistItems', []);
    });

    it('can remove item from wishlist', function () {
        $this->actingAs($this->user);
        $wishlistItem = Wishlist::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        Livewire::test(WishlistPage::class)
            ->call('removeFromWishlist', $wishlistItem->id)
            ->assertDispatched('toast');

        expect(Wishlist::find($wishlistItem->id))->toBeNull();
    });

    it('can add wishlist item to cart', function () {
        $this->actingAs($this->user);

        Livewire::test(WishlistPage::class)
            ->call('addToCart', $this->product->id)
            ->assertDispatched('toast')
            ->assertDispatched('cart-updated');
    });

    it('updates wishlist items when wishlist-updated event is dispatched', function () {
        $this->actingAs($this->user);

        $component = Livewire::test(WishlistPage::class);

        // Add item to wishlist
        $this->wishlistService->addToWishlist($this->user, $this->product->id);

        // Dispatch the event that should trigger reload
        $component->dispatch('wishlist-updated')
            ->assertSet('wishlistItems', function ($items) {
                return count($items) === 1;
            });
    });
});

describe('Wishlist Model', function () {
    it('belongs to user', function () {
        $wishlist = Wishlist::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        expect($wishlist->user)->toBeInstanceOf(User::class);
        expect($wishlist->user->id)->toBe($this->user->id);
    });

    it('belongs to product', function () {
        $wishlist = Wishlist::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        expect($wishlist->product)->toBeInstanceOf(Product::class);
        expect($wishlist->product->id)->toBe($this->product->id);
    });

    it('has unique constraint on user_id and product_id', function () {
        Wishlist::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        expect(function () {
            Wishlist::factory()->create([
                'user_id' => $this->user->id,
                'product_id' => $this->product->id,
            ]);
        })->toThrow(\Exception::class);
    });
});

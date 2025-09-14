<?php

namespace App\Livewire\Storefront\Layout;

use App\Models\Catalog\Category;
use App\Services\Cart\CartService;
use App\Services\Cart\WishlistService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Navigation extends Component
{
    public $listeners = [
        'wishlist-updated' => 'refreshWishlistCount',
        'cart-updated' => 'refreshItemCount',
    ];

    public function getCategoriesProperty()
    {
        return Category::with('children.children')
            ->whereNull('parent_id')
            ->limit(20)
            ->orderBy('order_column', 'asc')
            ->get();
    }

    #[Computed]
    public function wishlistItemCount()
    {
        if (! auth()->check()) {
            return 0;
        }

        return app(WishlistService::class)->getWishlistCount(auth()->user());
    }

    #[Computed]
    public function cartItemCount()
    {
        return app(CartService::class)->getCartItemCount();
    }

    public function render()
    {
        return view('livewire.storefront.layout.navigation');
    }
}

<?php

namespace App\Livewire\Storefront\Product;

use App\Livewire\Storefront\Cart\BaseCart;
use App\Models\Product;

class Card extends BaseCart
{
    public Product $product;

    public $class = 'col-lg-4 col-md-4 col-6 col-sm-6';

    public function addToCart(): void
    {
        $this->getCartService()->addToCart($this->product->id);
        $this->dispatchCartUpdated('Product added to cart successfully!');
    }

    public function quickView(): void
    {
        $this->dispatch('quick-view', ['product' => $this->product]);
    }

    public function render()
    {
        return view('livewire.storefront.product.card');
    }
}

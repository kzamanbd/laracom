<?php

namespace App\Livewire\Storefront\Product;

use App\Livewire\Storefront\Cart\CartBase;
use App\Models\Product;
use Livewire\Attributes\On;

class QuickView extends CartBase
{
    public ?Product $product = null;

    public $showModal = false;

    public $isLoading = false;

    public $id = null;

    public $quantity = 1;

    #[On('quick-view')]
    public function quickView(Product $product): void
    {
        // Show modal and loading state first
        $this->showModal = true;
        $this->isLoading = true;
        $this->quantity = 1;
        $this->id = $product->id;

        // Load product data with relationships
        $this->product = $product->load('categories', 'tags', 'images', 'thumbnail');
        $this->isLoading = false;

        // Dispatch event after product is loaded to initialize sliders
        $this->dispatch('product-loaded-for-quick-view');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->product = null;
        $this->quantity = 1;
        $this->isLoading = false;
    }

    public function incrementQuantity(): void
    {
        $this->quantity++;
    }

    public function decrementQuantity(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(): void
    {
        if (! $this->product) {
            return;
        }

        $this->getCartService()->addToCart($this->product->id, $this->quantity);
        $this->dispatchCartUpdated('Product added to cart successfully!');
    }

    public function render()
    {
        return view('livewire.storefront.product.quick-view');
    }
}

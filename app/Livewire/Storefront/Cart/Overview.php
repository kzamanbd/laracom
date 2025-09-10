<?php

namespace App\Livewire\Storefront\Cart;

use Livewire\Attributes\Computed;

class Overview extends CartComponentBase
{
    /**
     * Get cart item count
     */
    #[Computed]
    public function itemCount(): int
    {
        return $this->getCartService()->getCartItemCount();
    }

    public function render()
    {
        return view('livewire.storefront.cart.overview', [
            'cart' => $this->cart(),
            'itemCount' => $this->itemCount(),
        ]);
    }
}

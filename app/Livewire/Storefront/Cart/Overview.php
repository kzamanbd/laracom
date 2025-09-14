<?php

namespace App\Livewire\Storefront\Cart;

class Overview extends CartBase
{
    public function render()
    {
        return view('livewire.storefront.cart.overview', [
            'cart' => $this->cart(),
        ]);
    }
}

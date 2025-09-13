<?php

namespace App\Livewire\Storefront\Cart;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.storefront', ['title' => 'Cart'])]
class Cart extends Component
{
    public function render()
    {
        return view('livewire.storefront.cart.cart');
    }
}

<?php

namespace App\Livewire\Storefront\Product;

use App\Models\Product;
use Livewire\Component;

class Card extends Component
{
    public Product $product;


    public function addToCart()
    {
        dd($this->product);
    }
    public function quickView()
    {
        dd($this->product);
    }
    public function render()
    {
        return view('livewire.storefront.product.card');
    }
}

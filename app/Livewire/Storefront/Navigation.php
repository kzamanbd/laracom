<?php

namespace App\Livewire\Storefront;

use App\Models\Category;
use Livewire\Component;

class Navigation extends Component
{
    public function getCategoriesProperty()
    {
        return Category::with('children')
            ->whereNull('parent_id')
            ->limit(20)
            ->orderBy('order_column', 'asc')
            ->get();
    }
    public function render()
    {
        return view('livewire.storefront.navigation');
    }
}

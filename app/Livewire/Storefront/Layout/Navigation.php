<?php

namespace App\Livewire\Storefront\Layout;

use App\Models\Catalog\Category;
use Livewire\Component;

class Navigation extends Component
{
    public function getCategoriesProperty()
    {
        return Category::with('children.children')
            ->whereNull('parent_id')
            ->limit(20)
            ->orderBy('order_column', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.storefront.layout.navigation');
    }
}

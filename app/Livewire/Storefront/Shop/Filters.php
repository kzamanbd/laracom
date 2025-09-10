<?php

namespace App\Livewire\Storefront\Shop;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Filters extends Component
{
    public $selectedCategories = [];

    public $priceRange = [0, 1000];

    public $minPrice = 0;

    public $maxPrice = 1000;

    public $selectedColors = [];

    public $selectedConditions = [];

    protected $listeners = ['applyFilters', 'resetFilters'];

    public function mount(): void
    {
        $this->initializePriceRange();
    }

    public function initializePriceRange(): void
    {
        $priceRange = Product::query()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();
        $this->minPrice = $priceRange->min_price ?? 0;
        $this->maxPrice = $priceRange->max_price ?? 1000;
    }

    #[Computed]
    public function categories()
    {
        return Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(10)
            ->get();
    }

    #[Computed]
    public function availableColors()
    {
        // Get unique colors from product attributes
        return Product::query()->whereNotNull('attributes->color')
            ->pluck('attributes')
            ->map(fn($attrs) => $attrs['color'] ?? null)
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }

    #[Computed]
    public function newProducts()
    {
        return Product::with(['thumbnail'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }

    public function updatedSelectedCategories(): void
    {
        $this->dispatchFiltersChanged();
    }

    public function updatedMinPrice(): void
    {
        $this->dispatchFiltersChanged();
    }

    public function updatedMaxPrice(): void
    {
        $this->dispatchFiltersChanged();
    }

    public function updatedSelectedColors(): void
    {
        $this->dispatchFiltersChanged();
    }

    public function updatedSelectedConditions(): void
    {
        $this->dispatchFiltersChanged();
    }

    protected function dispatchFiltersChanged(): void
    {
        $this->dispatch('filtersChanged', [
            'categories' => $this->selectedCategories,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'colors' => $this->selectedColors,
            'conditions' => $this->selectedConditions,
        ]);
    }

    public function resetFilters(): void
    {
        $this->selectedCategories = [];
        $this->selectedColors = [];
        $this->selectedConditions = [];
        $this->initializePriceRange();

        $this->dispatchFiltersChanged();
    }

    public function render()
    {
        return view('livewire.storefront.shop.filters');
    }
}

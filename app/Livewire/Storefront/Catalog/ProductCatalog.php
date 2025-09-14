<?php

namespace App\Livewire\Storefront\Catalog;

use App\Services\Product\ProductService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.storefront', ['title' => 'Shop'])]
class ProductCatalog extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPageItems = [15, 30, 60, 120, 240];

    public $sortOptions = [
        'newest_desc' => 'Newest',
        'price_asc' => 'Price: Low to High',
        'price_desc' => 'Price: High to Low',
        'name_asc' => 'Name: A to Z',
        'name_desc' => 'Name: Z to A',
        'avg_rating' => 'Avg. Rating',
    ];

    public $sortLabel = 'Newest';

    public $limit = 15;

    public $sort = 'newest';

    public $order = 'desc';

    // Filter properties
    public $filters = [
        'categories' => [],
        'minPrice' => null,
        'maxPrice' => null,
        'colors' => [],
        'conditions' => [],
    ];

    protected $queryString = [
        'limit' => ['except' => ''], // "except" removes it when null/empty
        'sort' => ['except' => 'newest'],
        'order' => ['except' => 'desc'],
    ];

    #[Computed]
    public function products()
    {
        return app(ProductService::class)->getShopProducts([
            'limit' => $this->limit,
            'sort' => $this->sort,
            'order' => $this->order,
            'filters' => $this->filters,
        ]);
    }

    #[On('filtersChanged')]
    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function setPerPage($perPage)
    {
        $this->limit = $perPage;
        $this->resetPage();
    }

    public function setSort($sortKey)
    {
        if (! array_key_exists($sortKey, $this->sortOptions)) {
            return; // Invalid sort key
        }
        $this->sortLabel = $this->sortOptions[$sortKey];

        if ($sortKey === 'avg_rating') {
            $this->sort = 'avg_rating';
            $this->order = 'desc';
            $this->resetPage();

            return;
        }

        [$this->sort, $this->order] = explode('_', $sortKey);
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.storefront.catalog.product-catalog');
    }
}

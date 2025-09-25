<?php

namespace App\Livewire\Storefront\Catalog;

use App\Services\Product\ProductService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.storefront', ['title' => 'Shop'])]
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

    public $category = null;

    public $min_price = null;

    public $max_price = null;

    public $colors = [];

    public $conditions = [];

    protected $queryString = [
        'limit' => ['except' => ''],
        'sort' => ['except' => 'newest'],
        'order' => ['except' => 'desc'],
        'category' => ['except' => ''],
        'min_price' => ['except' => 0],
        'max_price' => ['except' => 1000],
        'colors' => ['except' => ''],
        'conditions' => ['except' => ''],
    ];

    #[Computed]
    public function products()
    {
        return app(ProductService::class)->getShopProducts([
            'limit' => $this->limit,
            'sort' => $this->sort,
            'order' => $this->order,
            'categories' => $this->category,
            'minPrice' => $this->min_price,
            'maxPrice' => $this->max_price,
            'colors' => $this->colors,
            'conditions' => $this->conditions,
        ]);
    }

    #[On('filtersChanged')]
    public function updateFilters($filters)
    {
        $this->category = $filters['categories'];
        $this->min_price = $filters['minPrice'];
        $this->max_price = $filters['maxPrice'];
        $this->colors = $filters['colors'];
        $this->conditions = $filters['conditions'];
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

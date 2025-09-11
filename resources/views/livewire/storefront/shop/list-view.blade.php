<div class="row">
    <div class="col-lg-9">
        <div class="shop-product-fillter">
            <div class="totall-product">
                <p>
                    We found <strong class="text-brand">{{ $this->products->total() }}</strong> items for you!
                </p>
            </div>
            <div class="sort-by-product-area">
                <div class="sort-by-cover mr-10">
                    <div class="sort-by-product-wrap">
                        <div class="sort-by">
                            <span><i class="fi-rs-apps"></i>Show:</span>
                        </div>
                        <div class="sort-by-dropdown-wrap">
                            <span> {{ $limit }}
                                <i class="fi-rs-angle-small-down"></i>
                            </span>
                        </div>
                    </div>
                    <div class="sort-by-dropdown">
                        <ul>
                            @foreach ($perPageItems as $item)
                                <li>
                                    <a @class(['active' => $item == $limit]) wire:click="setPerPage({{ $item }})">
                                        {{ $item }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="sort-by-cover">
                    <div class="sort-by-product-wrap">
                        <div class="sort-by">
                            <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                        </div>
                        <div class="sort-by-dropdown-wrap">
                            <span> {{ $sortLabel }} <i class="fi-rs-angle-small-down"></i></span>
                        </div>
                    </div>
                    <div class="sort-by-dropdown">
                        <ul>
                            @foreach ($sortOptions as $key => $label)
                                <li>
                                    <a wire:click="setSort('{{ $key }}')">{{ $label }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row product-grid-3">
            @foreach ($this->products as $product)
                @livewire('storefront.product.card', ['product' => $product], key($product->id))
            @endforeach
        </div>
        <!--pagination-->
        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
            {{ $this->products->links('livewire.pagination') }}
        </div>
    </div>
    @livewire('storefront.shop.filters')
</div>

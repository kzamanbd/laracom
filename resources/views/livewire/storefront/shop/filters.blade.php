<div class="col-lg-3 primary-sidebar sticky-sidebar">
    <div class="row">
        <div class="col-lg-12 col-mg-6"></div>
        <div class="col-lg-12 col-mg-6"></div>
    </div>
    <div class="widget-category mb-30">
        <h5 class="section-title style-1 mb-30 wow fadeIn animated">Category</h5>
        <ul class="categories custome-checkbox">
            @foreach ($this->categories as $category)
                <li class="d-flex align-items-center">
                    <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category->id }}"
                        class="form-check-input me-2" id="category-{{ $category->id }}">
                    <label for="category-{{ $category->id }}" class="form-check-label">
                        {{ $category->name }} ({{ $category->products_count }})
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Filter By Price -->
    <div class="sidebar-widget price_range range mb-30">
        <div class="widget-header position-relative mb-20 pb-10">
            <h5 class="widget-title mb-10">Filter by price</h5>
            <div class="bt-1 border-color-1"></div>
        </div>
        <div class="price-filter">
            <div class="price-filter-inner">
                <div id="slider-range"></div>
                <div class="price_slider_amount">
                    <div class="label-input">
                        <span>Range:</span>
                        {{-- TODO: dynamic the price range --}}
                        <input type="text" id="amount" name="price" placeholder="Add Your Price" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-group">
            @if (count($this->availableColors) > 0)
                <div class="list-group-item mb-10 mt-10">
                    <label class="fw-900">Color</label>
                    <div class="custome-checkbox">
                        @foreach ($this->availableColors as $color)
                            <div class="mb-2">
                                <input class="form-check-input" type="checkbox" wire:model.live="selectedColors"
                                    id="color-{{ $loop->index }}" value="{{ $color }}">
                                <label class="form-check-label" for="color-{{ $loop->index }}">
                                    <span>{{ ucfirst($color) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="list-group-item mb-10 mt-10">
                <label class="fw-900 mt-15">Item Condition</label>
                <div class="custome-checkbox">
                    <div class="mb-2">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedConditions"
                            id="condition-new" value="new">
                        <label class="form-check-label" for="condition-new">
                            <span>New</span>
                        </label>
                    </div>
                    <div class="mb-2">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedConditions"
                            id="condition-refurbished" value="refurbished">
                        <label class="form-check-label" for="condition-refurbished">
                            <span>Refurbished</span>
                        </label>
                    </div>
                    <div class="mb-2">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedConditions"
                            id="condition-used" value="used">
                        <label class="form-check-label" for="condition-used">
                            <span>Used</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <button wire:click="resetFilters" class="btn btn-sm btn-default">
            <i class="fi-rs-filter mr-5"></i> Clear Filters
        </button>
    </div>
    <!-- Product sidebar Widget -->
    <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
        <div class="widget-header position-relative mb-20 pb-10">
            <h5 class="widget-title mb-10">New products</h5>
            <div class="bt-1 border-color-1"></div>
        </div>
        @foreach ($this->newProducts as $product)
            <div class="single-post clearfix">
                <div class="image">
                    <img src="{{ $product->thumbnail_path }}" alt="{{ $product->name }}">
                </div>
                <div class="content pt-10">
                    <h5><a href="{{ route('product', $product->route_key) }}">{{ $product->name }}</a></h5>
                    <p class="price mb-0 mt-5">{{ formatPrice($product->price) }}</p>
                    <div class="product-rate">
                        <div class="product-rating" style="width:90%"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="banner-img wow fadeIn mb-45 animated d-lg-block d-none">
        <img src="assets/imgs/banner/banner-11.jpg" alt="">
        <div class="banner-text">
            <span>Women Zone</span>
            <h4>Save 17% on <br>Office Dress</h4>
            <a href="shop.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
        </div>
    </div>
</div>

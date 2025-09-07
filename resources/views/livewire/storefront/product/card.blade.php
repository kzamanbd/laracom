<div class="col-lg-4 col-md-4 col-6 col-sm-6">
    <div class="product-cart-wrap mb-30">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ route('product', ['slug' => $product->slug]) }}">
                    <img class="default-img" src="{{ $product->thumbnail }}" alt="">
                    <img class="hover-img" src="{{ $product->thumbnail }}" alt="">
                </a>
            </div>
            <div class="product-action-1">
                <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal"
                    data-bs-target="#quickViewModal" wire:click="quickView">
                    <i class="fi-rs-search"></i>
                </a>
                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="wishlist.php">
                    <i class="fi-rs-heart"></i>
                </a>
                <a aria-label="Compare" class="action-btn hover-up" href="compare.php">
                    <i class="fi-rs-shuffle"></i>
                </a>
            </div>
            <div class="product-badges product-badges-position product-badges-mrg">
                {{-- Todo: need to dynamic --}}
                <span class="hot">Hot</span>
            </div>
        </div>
        <div class="product-content-wrap">
            <div class="product-category">
                @foreach ($product->categories as $category)
                    <a href="{{ route('shop', ['category' => $category->slug]) }}">
                        {{ $category->name }}
                    </a>
                    {{-- Max 2 category show in product card --}}
                    @break($loop->iteration > 2)
                @endforeach
            </div>
            <h2>
                <a href="{{ route('product', ['slug' => $product->slug]) }}">
                    {{ $product->name }}
                </a>
            </h2>
            <div class="rating-result" title="90%">
                <span>
                    <span>90%</span>
                </span>
            </div>
            <div class="product-price">
                <span>${{ $product->sale_price }} </span>
                @if ($product->sale_price < $product->price)
                    <span class="old-price">${{ $product->price }}</span>
                @endif
            </div>
            <div class="product-action-1 show">
                <a aria-label="Add To Cart" class="action-btn hover-up" wire:click="addToCart">
                    <i class="fi-rs-shopping-bag-add"></i>
                </a>
            </div>
        </div>
    </div>
</div>

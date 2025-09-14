<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> Wishlist
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-30">
                        <h1 class="heading-2 mb-0">My Wishlist</h1>
                        <div class="wishlist-count">
                            <span class="text-muted">
                                You have <strong class="text-brand">{{ count($wishlistItems) }}</strong> items in your
                                wishlist
                            </span>
                        </div>
                    </div>

                    @if (count($wishlistItems) > 0)
                        <!-- Wishlist Items -->
                        <div class="table-responsive wishlist-table">
                            <table class="table shopping-summery text-center clean">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col">Image</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Stock Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample Wishlist Item 1 -->
                                    @foreach ($wishlistItems as $item)
                                        <tr class="pt-30">
                                            <td class="image product-thumbnail">
                                                <img src="{{ $item->product->thumbnail_path }}" alt="Product Image">
                                            </td>
                                            <td class="product-des product-name">
                                                <h5 class="product-name">
                                                    <a href="{{ route('product', ['slug' => $item->product->slug]) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h5>
                                                <p class="font-xs text-muted">
                                                    {{ $item->product->description }}
                                                </p>
                                            </td>
                                            <td class="price" data-title="Price">
                                                <h4 class="text-brand">{{ formatPrice($item->product->price) }}</h4>
                                            </td>
                                            <td class="text-center" data-title="Stock">
                                                <span class="color3 font-weight-bold">In Stock</span>
                                            </td>
                                            <td class="text-center" data-title="Cart">
                                                <button class="btn btn-sm btn-cart" type="button"
                                                    wire:click="addToCart({{ $item->product->id }})">
                                                    <i class="fi-rs-shopping-bag mr-5"></i>Add to Cart
                                                </button>
                                            </td>
                                            <td class="action" data-title="Remove">
                                                <a href="#" class="text-muted wishlist-remove"
                                                    wire:click="removeFromWishlist({{ $item->id }})"
                                                    title="Remove from wishlist">
                                                    <i class="fi-rs-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Wishlist Actions -->
                        <div class="row mt-50">
                            <div class="col-lg-6 col-md-6">
                                <div class="cart-actions">
                                    <a href="{{ route('shop') }}" class="btn btn-fill-line">
                                        <i class="fi-rs-shopping-bag mr-10"></i>Continue Shopping
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="cart-actions text-end">
                                    <a href="#" class="btn btn-fill-out btn-addall-cart">
                                        <i class="fi-rs-shopping-cart mr-10"></i>Add All to Cart
                                    </a>
                                    <a href="#" class="btn btn-outline ms-2 btn-clear-wishlist">
                                        <i class="fi-rs-trash mr-10"></i>Clear Wishlist
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty Wishlist State -->
                        <div class="empty-wishlist text-center">
                            <div class="py-5">
                                <h3 class="mb-3">Your wishlist is empty</h3>
                                <p class="text-muted mb-4">You don't have any products in the wishlist yet.<br>You will
                                    find a lot of interesting products on our Shop page.</p>
                                <a href="{{ route('shop') }}" class="btn btn-fill-out">
                                    <i class="fi-rs-shopping-bag mr-10"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    <section class="section-padding">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn">
                <h3 class="mb-2">You may also like</h3>
                <a class="show-all" href="{{ route('shop') }}">
                    All Products
                    <i class="fi-rs-angle-right"></i>
                </a>
            </div>
            <div class="row product-grid-4 mt-2">
                <!-- Sample Related Product 1 -->
                <div class="col-lg-3 col-md-4 col-6 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('product', ['slug' => 'sample-product-1']) }}">
                                    <img class="default-img" src="assets/imgs/shop/product-6-1.jpg" alt="">
                                    <img class="hover-img" src="assets/imgs/shop/product-6-2.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal"
                                    data-bs-target="#quickViewModal">
                                    <i class="fi-rs-eye"></i>
                                </a>
                                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shuffle"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="hot">Hot</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="{{ route('shop') }}">Women's Clothing</a>
                            </div>
                            <h2><a href="{{ route('product', ['slug' => 'sample-product-1']) }}">Cotton Blend
                                    V-Neck Sweater</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width:90%">
                                    </div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.5)</span>
                            </div>
                            <div class="product-price">
                                <span>$45.50</span>
                                <span class="old-price">$55.25</span>
                            </div>
                            <div class="product-action-1 show">
                                <a aria-label="Add To Cart" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shopping-bag-add"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Related Product 2 -->
                <div class="col-lg-3 col-md-4 col-6 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('product', ['slug' => 'sample-product-2']) }}">
                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="">
                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal"
                                    data-bs-target="#quickViewModal">
                                    <i class="fi-rs-eye"></i>
                                </a>
                                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shuffle"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="new">New</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="{{ route('shop') }}">Women's Clothing</a>
                            </div>
                            <h2><a href="{{ route('product', ['slug' => 'sample-product-2']) }}">Casual Denim
                                    Jacket</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width:85%">
                                    </div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.2)</span>
                            </div>
                            <div class="product-price">
                                <span>$78.00</span>
                            </div>
                            <div class="product-action-1 show">
                                <a aria-label="Add To Cart" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shopping-bag-add"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Related Product 3 -->
                <div class="col-lg-3 col-md-4 col-6 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('product', ['slug' => 'sample-product-3']) }}">
                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="">
                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal"
                                    data-bs-target="#quickViewModal">
                                    <i class="fi-rs-eye"></i>
                                </a>
                                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shuffle"></i></a>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                <span class="sale">Sale</span>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="{{ route('shop') }}">Women's Clothing</a>
                            </div>
                            <h2><a href="{{ route('product', ['slug' => 'sample-product-3']) }}">Elegant Evening
                                    Dress</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width:95%">
                                    </div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.8)</span>
                            </div>
                            <div class="product-price">
                                <span>$125.00</span>
                                <span class="old-price">$150.00</span>
                            </div>
                            <div class="product-action-1 show">
                                <a aria-label="Add To Cart" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shopping-bag-add"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Related Product 4 -->
                <div class="col-lg-3 col-md-4 col-6 col-sm-6">
                    <div class="product-cart-wrap mb-30">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{ route('product', ['slug' => 'sample-product-4']) }}">
                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="">
                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal"
                                    data-bs-target="#quickViewModal">
                                    <i class="fi-rs-eye"></i>
                                </a>
                                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-heart"></i></a>
                                <a aria-label="Compare" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shuffle"></i></a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="{{ route('shop') }}">Women's Clothing</a>
                            </div>
                            <h2><a href="{{ route('product', ['slug' => 'sample-product-4']) }}">Comfortable Yoga
                                    Pants</a></h2>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width:88%">
                                    </div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.4)</span>
                            </div>
                            <div class="product-price">
                                <span>$35.00</span>
                            </div>
                            <div class="product-action-1 show">
                                <a aria-label="Add To Cart" class="action-btn hover-up" href="#"><i
                                        class="fi-rs-shopping-bag-add"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

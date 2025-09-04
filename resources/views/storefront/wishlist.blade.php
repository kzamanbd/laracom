<x-layouts.app title="Wishlist">
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
                                <span class="text-muted">You have <strong class="text-brand">5</strong> items in your
                                    wishlist</span>
                            </div>
                        </div>

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
                                    <tr class="pt-30">
                                        <td class="image product-thumbnail">
                                            <img src="assets/imgs/shop/product-1-2.jpg" alt="Product Image">
                                        </td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ route('product', ['slug' => 'j-crew-mercantile-womens-short-sleeve']) }}">
                                                    J.Crew Mercantile Women's Short-Sleeve
                                                </a>
                                            </h5>
                                            <p class="font-xs text-muted">
                                                High-quality cotton blend shirt perfect for casual wear
                                            </p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-brand">$65.00</h4>
                                        </td>
                                        <td class="text-center" data-title="Stock">
                                            <span class="color3 font-weight-bold">In Stock</span>
                                        </td>
                                        <td class="text-center" data-title="Cart">
                                            <button class="btn btn-sm btn-cart" type="button">
                                                <i class="fi-rs-shopping-bag mr-5"></i>Add to Cart
                                            </button>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <a href="#" class="text-muted wishlist-remove"
                                                title="Remove from wishlist">
                                                <i class="fi-rs-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Sample Wishlist Item 2 -->
                                    <tr class="pt-30">
                                        <td class="image product-thumbnail">
                                            <img src="assets/imgs/shop/product-2-2.jpg" alt="Product Image">
                                        </td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ route('product', ['slug' => 'amazon-brand-daily-ritual']) }}">
                                                    Amazon Brand - Daily Ritual Women's Jersey
                                                </a>
                                            </h5>
                                            <p class="font-xs text-muted">
                                                Comfortable jersey fabric with modern fit
                                            </p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-brand">$32.00</h4>
                                        </td>
                                        <td class="text-center" data-title="Stock">
                                            <span class="color3 font-weight-bold">In Stock</span>
                                        </td>
                                        <td class="text-center" data-title="Cart">
                                            <button class="btn btn-sm btn-cart" type="button">
                                                <i class="fi-rs-shopping-bag mr-5"></i>Add to Cart
                                            </button>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <a href="#" class="text-muted wishlist-remove"
                                                title="Remove from wishlist">
                                                <i class="fi-rs-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Sample Wishlist Item 3 -->
                                    <tr class="pt-30">
                                        <td class="image product-thumbnail">
                                            <img src="assets/imgs/shop/product-3-2.jpg" alt="Product Image">
                                        </td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ route('product', ['slug' => 'amazon-essentials-womens-tank']) }}">
                                                    Amazon Essentials Women's Tank Top
                                                </a>
                                            </h5>
                                            <p class="font-xs text-muted">
                                                Essential tank top for layering or standalone wear
                                            </p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-brand">$18.00</h4>
                                        </td>
                                        <td class="text-center" data-title="Stock">
                                            <span class="color2 font-weight-bold">Out of Stock</span>
                                        </td>
                                        <td class="text-center" data-title="Cart">
                                            <button class="btn btn-sm btn-secondary" type="button" disabled>
                                                <i class="fi-rs-headset mr-5"></i>Contact Us
                                            </button>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <a href="#" class="text-muted wishlist-remove"
                                                title="Remove from wishlist">
                                                <i class="fi-rs-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Sample Wishlist Item 4 -->
                                    <tr class="pt-30">
                                        <td class="image product-thumbnail">
                                            <img src="assets/imgs/shop/product-4-2.jpg" alt="Product Image">
                                        </td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ route('product', ['slug' => 'hanes-womens-relaxed-fit']) }}">
                                                    Hanes Women's Relaxed Fit Jersey ComfortSoft
                                                </a>
                                            </h5>
                                            <p class="font-xs text-muted">
                                                Ultra-soft fabric with relaxed comfortable fit
                                            </p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-brand">$29.00</h4>
                                        </td>
                                        <td class="text-center" data-title="Stock">
                                            <span class="color3 font-weight-bold">In Stock</span>
                                        </td>
                                        <td class="text-center" data-title="Cart">
                                            <button class="btn btn-sm btn-cart" type="button">
                                                <i class="fi-rs-shopping-bag mr-5"></i>Add to Cart
                                            </button>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <a href="#" class="text-muted wishlist-remove"
                                                title="Remove from wishlist">
                                                <i class="fi-rs-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Sample Wishlist Item 5 -->
                                    <tr class="pt-30">
                                        <td class="image product-thumbnail">
                                            <img src="assets/imgs/shop/product-5-2.jpg" alt="Product Image">
                                        </td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ route('product', ['slug' => 'champion-womens-powersoft']) }}">
                                                    Champion Women's PowerSoft Performance T-Shirt
                                                </a>
                                            </h5>
                                            <p class="font-xs text-muted">
                                                Moisture-wicking performance fabric for active lifestyle
                                            </p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-brand">$24.00</h4>
                                        </td>
                                        <td class="text-center" data-title="Stock">
                                            <span class="color3 font-weight-bold">In Stock</span>
                                        </td>
                                        <td class="text-center" data-title="Cart">
                                            <button class="btn btn-sm btn-cart" type="button">
                                                <i class="fi-rs-shopping-bag mr-5"></i>Add to Cart
                                            </button>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <a href="#" class="text-muted wishlist-remove"
                                                title="Remove from wishlist">
                                                <i class="fi-rs-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty Wishlist State -->
                        <div class="empty-wishlist text-center" style="display: none;">
                            <div class="py-5">
                                <img src="assets/imgs/page/empty-wishlist.png" alt="Empty Wishlist" class="mb-3"
                                    style="max-width: 200px;">
                                <h3 class="mb-3">Your wishlist is empty</h3>
                                <p class="text-muted mb-4">You don't have any products in the wishlist yet.<br>You will
                                    find a lot of interesting products on our Shop page.</p>
                                <a href="{{ route('shop') }}" class="btn btn-fill-out">
                                    <i class="fi-rs-shopping-bag mr-10"></i>Continue Shopping
                                </a>
                            </div>
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
                                        <img class="default-img" src="assets/imgs/shop/product-6-1.jpg"
                                            alt="">
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
                                        <img class="default-img" src="assets/imgs/shop/product-7-1.jpg"
                                            alt="">
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
                                        <img class="default-img" src="assets/imgs/shop/product-8-1.jpg"
                                            alt="">
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
                                        <img class="default-img" src="assets/imgs/shop/product-9-1.jpg"
                                            alt="">
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

    @push('scripts')
        <script>
            // Wishlist functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Remove item from wishlist
                document.querySelectorAll('.wishlist-remove').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                            // Here you would make an AJAX call to remove the item
                            this.closest('tr').remove();
                            updateWishlistCount();
                        }
                    });
                });

                // Add all to cart
                document.querySelector('.btn-addall-cart')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Add all available items to cart?')) {
                        // Here you would make an AJAX call to add all items to cart
                        alert('All available items have been added to cart!');
                    }
                });

                // Clear wishlist
                document.querySelector('.btn-clear-wishlist')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to clear your entire wishlist?')) {
                        // Here you would make an AJAX call to clear the wishlist
                        document.querySelector('.wishlist-table').style.display = 'none';
                        document.querySelector('.empty-wishlist').style.display = 'block';
                        document.querySelector('.row.mt-50').style.display = 'none';
                    }
                });

                // Add to cart buttons
                document.querySelectorAll('.btn-cart').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Here you would make an AJAX call to add item to cart
                        this.innerHTML = '<i class="fi-rs-check mr-5"></i>Added';
                        this.classList.remove('btn-cart');
                        this.classList.add('btn-success');
                        this.disabled = true;
                    });
                });

                function updateWishlistCount() {
                    const remainingItems = document.querySelectorAll('.wishlist-table tbody tr').length;
                    document.querySelector('.wishlist-count strong').textContent = remainingItems;

                    if (remainingItems === 0) {
                        document.querySelector('.wishlist-table').style.display = 'none';
                        document.querySelector('.empty-wishlist').style.display = 'block';
                        document.querySelector('.row.mt-50').style.display = 'none';
                    }
                }
            });
        </script>
    @endpush
</x-layouts.app>

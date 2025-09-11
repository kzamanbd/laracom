<div wire:ignore.self class="modal fade custom-modal" id="quickViewModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            <!-- Loading Placeholder -->
            <div class="modal-body">
                @if ($isLoading || !$product)
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-gallery">
                                <!-- Image Placeholder -->
                                <div class="product-image-placeholder border-radius-10"
                                    style="height: 400px; background: linear-gradient(90deg, #f8f9fa 25%, #e9ecef 50%, #f8f9fa 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; display: flex; align-items: center; justify-content: center;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info">
                                <!-- Content Placeholders -->
                                <div class="placeholder-glow">
                                    <div class="placeholder col-8 mb-3" style="height: 2rem;"></div>
                                    <div class="placeholder col-6 mb-2"></div>
                                    <div class="placeholder col-4 mb-2"></div>
                                    <div class="placeholder col-7 mb-3"></div>
                                    <div class="placeholder col-9 mb-2"></div>
                                    <div class="placeholder col-5 mb-2"></div>
                                    <div class="placeholder col-8 mb-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($product)
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider slider-loading" wire:ignore>
                                    @if ($product->images && $product->images->count() > 0)
                                        @foreach ($product->images as $image)
                                            <figure class="border-radius-10">
                                                <img src="{{ $image->file_path }}" alt="{{ $product->name }}" />
                                            </figure>
                                        @endforeach
                                    @else
                                        <figure class="border-radius-10">
                                            <img src="{{ $product->thumbnail_path }}" alt="{{ $product->name }}" />
                                        </figure>
                                    @endif
                                </div>
                                <!-- THUMBNAILS -->
                                @if ($product->images && $product->images->count() > 1)
                                    <div class="slider-nav-thumbnails pl-15 pr-15 slider-loading" wire:ignore>
                                        @foreach ($product->images as $image)
                                            <div>
                                                <img src="{{ $image->file_path }}" alt="{{ $product->name }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <!-- End Gallery -->
                            <div class="social-icons single-share">
                                <ul class="text-grey-5 d-inline-block">
                                    <li><strong class="mr-10">Share this:</strong></li>
                                    <li class="social-facebook">
                                        <a href="#">
                                            <img src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}" />
                                        </a>
                                    </li>
                                    <li class="social-twitter">
                                        <a href="#">
                                            <img src="{{ asset('assets/imgs/theme/icons/icon-twitter.svg') }}" />
                                        </a>
                                    </li>
                                    <li class="social-instagram">
                                        <a href="#">
                                            <img src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}" />
                                        </a>
                                    </li>
                                    <li class="social-linkedin">
                                        <a href="#">
                                            <img src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}" />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info">
                                <h3 class="title-detail mt-30">{{ $product->name }}</h3>
                                <div class="product-detail-rating">
                                    <div class="pro-details-brand">
                                        <span> Categories:
                                            @foreach ($product->categories as $category)
                                                <a href="{{ route('shop', ['category' => $category->slug]) }}">
                                                    {{ $category->name }}
                                                </a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%;"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (25 reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        <ins>
                                            <span class="text-brand">
                                                {{ formatPrice($product->sale_price) }}
                                            </span>
                                        </ins>
                                        @if ($product->sale_price < $product->price)
                                            <ins>
                                                <span class="old-price font-md ml-15">
                                                    {{ formatPrice($product->price) }}
                                                </span>
                                            </ins>
                                            <span class="save-price font-md color3 ml-15">
                                                {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                                Off
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                <div class="short-desc mb-30">
                                    <p class="font-sm">{{ $product->short_description ?? $product->description }}
                                    </p>
                                </div>

                                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                <div class="detail-extralink">
                                    <div class="detail-qty border radius">
                                        <a href="#" wire:click="decrementQuantity" class="qty-down">
                                            <i class="fi-rs-angle-small-down"></i>
                                        </a>
                                        <span class="qty-val">{{ $quantity }}</span>
                                        <a href="#" wire:click="incrementQuantity" class="qty-up">
                                            <i class="fi-rs-angle-small-up"></i>
                                        </a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="button" wire:click="addToCart" class="button button-add-to-cart">
                                            <span wire:loading.remove wire:target="addToCart">Add to cart</span>
                                            <span wire:loading wire:target="addToCart">Adding...</span>
                                        </button>
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#">
                                            <i class="fi-rs-heart"></i>
                                        </a>
                                        <a aria-label="Compare" class="action-btn hover-up" href="#">
                                            <i class="fi-rs-shuffle"></i>
                                        </a>
                                    </div>
                                </div>
                                <ul class="product-meta font-xs color-grey mt-50">
                                    <li class="mb-5">SKU: <a href="#">{{ $product->sku ?? 'N/A' }}</a></li>
                                    @if ($product->tags && $product->tags->count() > 0)
                                        <li class="mb-5">Tags:
                                            @foreach ($product->tags as $tag)
                                                <a href="#" rel="tag">{{ $tag->name }}</a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </li>
                                    @endif
                                    <li>
                                        Availability:
                                        <span class="in-stock text-success ml-5">{{ $product->stock_quantity ?? 0 }}
                                            Items In Stock
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @script
        <script>
            let productSlider = null;
            let thumbnailSlider = null;

            // Initialize modal event listeners
            const modalElement = document.getElementById('quickViewModal');

            if (modalElement) {
                // When modal is hidden, cleanup
                modalElement.addEventListener('hidden.bs.modal', function() {
                    destroySliders();
                    $wire.closeModal();
                });
            }

            // Listen for when product data is loaded
            $wire.on('product-loaded-for-quick-view', waitForImagesAndInitialize);

            function waitForImagesAndInitialize() {
                const productSliderEl = document.querySelector('#quickViewModal .product-image-slider');

                if (!productSliderEl) {
                    console.log('Product slider element not found, retrying...');
                    setTimeout(waitForImagesAndInitialize, 100);
                    return;
                }

                const images = productSliderEl.querySelectorAll('img');

                if (images.length === 0) {
                    console.log('No images found, retrying...');
                    setTimeout(waitForImagesAndInitialize, 100);
                    return;
                }

                initializeSliders();
            }

            function initializeSliders() {
                const productSliderEl = document.querySelector('#quickViewModal .product-image-slider');
                const thumbnailSliderEl = document.querySelector('#quickViewModal .slider-nav-thumbnails');

                // Initialize product slider
                if (productSliderEl) {
                    const images = productSliderEl.querySelectorAll('figure');

                    if (images.length > 0) {
                        try {
                            // Show the slider before initializing
                            productSliderEl.style.visibility = 'visible';

                            $(productSliderEl).slick({
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                fade: false,
                                asNavFor: thumbnailSliderEl ? '#quickViewModal .slider-nav-thumbnails' : null,
                                adaptiveHeight: true,
                                lazyLoad: 'ondemand'
                            });

                            productSlider = productSliderEl;
                            console.log('Product slider initialized successfully');
                        } catch (error) {
                            console.error('Error initializing product slider:', error);
                            // Show slider as fallback
                            productSliderEl.style.visibility = 'visible';
                        }
                    }
                }

                // Initialize thumbnail slider
                if (thumbnailSliderEl) {
                    const thumbnails = thumbnailSliderEl.querySelectorAll('div');

                    if (thumbnails.length > 1) {
                        try {
                            // Show the slider before initializing
                            thumbnailSliderEl.style.visibility = 'visible';

                            $(thumbnailSliderEl).slick({
                                slidesToShow: Math.min(4, thumbnails.length),
                                slidesToScroll: 1,
                                asNavFor: '#quickViewModal .product-image-slider',
                                dots: false,
                                focusOnSelect: true,
                                centerMode: false,
                                variableWidth: false,
                                prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-angle-left"></i></button>',
                                nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-angle-right"></i></button>',
                                responsive: [{
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: Math.min(3, thumbnails.length)
                                    }
                                }]
                            });

                            thumbnailSlider = thumbnailSliderEl;

                            // Set up thumbnail active states
                            $(thumbnailSliderEl).find('.slick-slide').removeClass('slick-active');
                            $(thumbnailSliderEl).find('.slick-slide').eq(0).addClass('slick-active');

                            // Sync thumbnail active state with main slider
                            $(productSliderEl).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                                $(thumbnailSliderEl).find('.slick-slide').removeClass('slick-active');
                                $(thumbnailSliderEl).find('.slick-slide').eq(nextSlide).addClass('slick-active');
                            });

                            console.log('Thumbnail slider initialized successfully');
                        } catch (error) {
                            console.error('Error initializing thumbnail slider:', error);
                            // Show slider as fallback
                            thumbnailSliderEl.style.visibility = 'visible';
                        }
                    } else {
                        // Single thumbnail, just show it
                        thumbnailSliderEl.style.visibility = 'visible';
                    }
                }
            }

            function destroySliders() {
                console.log('Destroying sliders...');

                if (typeof $ !== 'undefined') {
                    if (productSlider && $(productSlider).hasClass('slick-initialized')) {
                        try {
                            $(productSlider).off(); // Remove all event listeners
                            $(productSlider).slick('unslick');
                            console.log('Product slider destroyed');
                        } catch (error) {
                            console.error('Error destroying product slider:', error);
                        }
                    }

                    if (thumbnailSlider && $(thumbnailSlider).hasClass('slick-initialized')) {
                        try {
                            $(thumbnailSlider).off(); // Remove all event listeners
                            $(thumbnailSlider).slick('unslick');
                        } catch (error) {
                            console.error('Error destroying thumbnail slider:', error);
                        }
                    }
                }

                // Reset loading states
                const productSliderEl = document.querySelector('#quickViewModal .product-image-slider');
                const thumbnailSliderEl = document.querySelector('#quickViewModal .slider-nav-thumbnails');

                if (productSliderEl) {
                    productSliderEl.classList.remove('slider-loaded');
                    productSliderEl.classList.add('slider-loading');
                    productSliderEl.style.visibility = 'hidden';
                }

                if (thumbnailSliderEl) {
                    thumbnailSliderEl.classList.remove('slider-loaded');
                    thumbnailSliderEl.classList.add('slider-loading');
                    thumbnailSliderEl.style.visibility = 'hidden';
                }

                productSlider = null;
                thumbnailSlider = null;
            }
        </script>
    @endscript
</div>

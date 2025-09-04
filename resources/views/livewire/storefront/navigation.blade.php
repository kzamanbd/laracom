<div>
    <header class="header-area header-style-1 header-height-2">
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li>
                                    <a class="language-dropdown-active" href="#"> <i class="fi-rs-world"></i> English
                                        <i class="fi-rs-angle-small-down"></i></a>
                                    <ul class="language-dropdown">
                                        <li><a href="#"><img src="{{ asset('assets/imgs/theme/flag-fr.png') }}"
                                                    alt="">Français</a></li>
                                        <li><a href="#"><img src="{{ asset('assets/imgs/theme/flag-dt.png') }}"
                                                    alt="">Deutsch</a></li>
                                        <li><a href="#"><img src="{{ asset('assets/imgs/theme/flag-ru.png') }}"
                                                    alt="">Pусский</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                                <ul>
                                    <li>Get great devices up to 50% off <a href="shop.html">View details</a></li>
                                    <li>Supper Value Deals - Save more with coupons</li>
                                    <li>Trendy 25silver jewelry, save up 35% off today <a href="shop.html">Shop now</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>
                                <li>
                                    <i class="fi-rs-key"></i>
                                    <a href="{{ route('login') }}">Log In </a>
                                    / <a href="{{ route('register') }}">Sign Up</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/imgs/logo/logo.png') }}" alt="logo">
                        </a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-1">
                            <form action="#">
                                <input type="text" placeholder="Search for items...">
                            </form>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-icon-2">
                                    <a href="{{ route('wishlist') }}">
                                        <img class="svgInject" alt="DraftScripts"
                                            src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}">
                                        <span class="pro-count blue">4</span>
                                    </a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="{{ route('cart') }}">
                                        <img alt="DraftScripts"
                                            src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}">
                                        <span class="pro-count blue">2</span>
                                    </a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="product-details.html"><img alt="DraftScripts"
                                                            src="{{ asset('assets/imgs/shop/thumbnail-3.jpg') }}"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="product-details.html">Daisy Casual Bag</a></h4>
                                                    <h4><span>1 × </span>$800.00</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="fi-rs-cross-small"></i></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="product-details.html"><img alt="DraftScripts"
                                                            src="{{ asset('assets/imgs/shop/thumbnail-2.jpg') }}"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="product-details.html">Corduroy Shirts</a></h4>
                                                    <h4><span>1 × </span>$3200.00</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="fi-rs-cross-small"></i></a>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                <h4>Total <span>$4000.00</span></h4>
                                            </div>
                                            <div class="shopping-cart-button">
                                                <a href="{{ route('cart') }}" class="outline">View cart</a>
                                                <a href="{{ route('checkout') }}">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/imgs/logo/logo.png') }}" alt="logo">
                        </a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categori-button-active" href="#">
                                <span class="fi-rs-apps"></span> Categories
                            </a>
                            <div class="categori-dropdown-wrap categori-dropdown-active-large">
                                <ul>
                                    @foreach ($this->categories as $category)
                                        @if ($loop->iteration > 10)
                                            <!-- More categories -->
                                            <li>
                                                <ul class="more_slide_open" style="display: none;">
                                                    <li>
                                                        <a href="{{ route('shop', ['category' => $category->slug]) }}">
                                                            {{ $category->name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            @continue
                                        @endif
                                        <li @class(['has-children' => $category->children->isNotEmpty()])>
                                            {{-- Todo: Add icon for category --}}
                                            <a href="{{ route('shop', ['category' => $category->slug]) }}">
                                                {{ $category->name }}
                                            </a>

                                            @if ($category->children->isNotEmpty())
                                                <div class="dropdown-menu">
                                                    <ul class="mega-menu d-lg-flex">
                                                        <li class="mega-menu-col col-lg-7">
                                                            <ul class="d-lg-flex">
                                                                @foreach ($category->children as $childCategory)
                                                                    {{-- Limit to 2 columns --}}
                                                                    @break($loop->iteration == 3)
                                                                    <li class="mega-menu-col col-lg-6">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="{{ route('shop', ['category' => $childCategory->slug]) }}"
                                                                                    class="submenu-title">
                                                                                    {{ $childCategory->name }}
                                                                                </a>
                                                                            </li>
                                                                            @foreach ($childCategory->children as $subChildCategory)
                                                                                <li>
                                                                                    <a class="dropdown-item nav-link nav_item"
                                                                                        href="{{ route('shop', ['category' => $subChildCategory->slug]) }}">
                                                                                        {{ $subChildCategory->name }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                        <li class="mega-menu-col col-lg-5">
                                                            <div class="header-banner2">
                                                                <img src="{{ asset('assets/imgs/banner/menu-banner-2.jpg') }}"
                                                                    alt="menu_banner1">
                                                                <div class="banne_info">
                                                                    <h6>10% Off</h6>
                                                                    <h4>New Arrival</h4>
                                                                    <a href="#">Shop now</a>
                                                                </div>
                                                            </div>
                                                            <div class="header-banner2">
                                                                <img src="{{ asset('assets/imgs/banner/menu-banner-3.jpg') }}"
                                                                    alt="menu_banner2">
                                                                <div class="banne_info">
                                                                    <h6>15% Off</h6>
                                                                    <h4>Hot Deals</h4>
                                                                    <a href="#">Shop now</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="more_categories">Show more...</div>
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                    <li><a class="active" href="{{ route('home') }}">Home </a></li>
                                    <li><a href="{{ route('about') }}">About</a></li>
                                    <li><a href="{{ route('shop') }}">Shop</a></li>
                                    <li class="position-static">
                                        <a href="{{ route('shop') }}">
                                            Our Collections <i class="fi-rs-angle-down"></i>
                                        </a>
                                        <ul class="mega-menu">
                                            @foreach ($this->categories as $category)
                                                <li class="sub-mega-menu sub-mega-menu-width-22">
                                                    {{-- Limit to 3 categories --}}
                                                    @break($loop->iteration > 3)

                                                    <a class="menu-title"
                                                        href="{{ route('shop', ['category' => $category->slug]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                    @if ($category->children->isNotEmpty())
                                                        <ul>
                                                            @foreach ($category->children as $childCategory)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('shop', ['category' => $childCategory->slug]) }}">
                                                                        {{ $childCategory->name }}
                                                                    </a>
                                                                </li>
                                                                {{-- Limit to 5 subcategories --}}
                                                                @break($loop->iteration == 5)
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                            {{-- Todo: Dynamic with offer --}}
                                            <li class="sub-mega-menu sub-mega-menu-width-34">
                                                <div class="menu-banner-wrap">
                                                    <a href="product-details.html"><img
                                                            src="{{ asset('assets/imgs/banner/menu-banner.jpg') }}"
                                                            alt="DraftScripts"></a>
                                                    <div class="menu-banner-content">
                                                        <h4>Hot deals</h4>
                                                        <h3>Don't miss<br> Trending</h3>
                                                        <div class="menu-banner-price">
                                                            <span class="new-price text-success">Save to 50%</span>
                                                        </div>
                                                        <div class="menu-banner-btn">
                                                            <a href="product-details.html">Shop now</a>
                                                        </div>
                                                    </div>
                                                    <div class="menu-banner-discount">
                                                        <h3>
                                                            <span>35%</span>
                                                            off
                                                        </h3>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('blog') }}">Blog </a></li>
                                    <li><a href="{{ route('contact') }}">Contact</a></li>
                                    <li>
                                        <a href="{{ route('my-account') }}">
                                            My Account<i class="fi-rs-angle-down"></i>
                                        </a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('my-account') }}">Dashboard</a></li>
                                            <li><a href="#">Products</a></li>
                                            <li><a href="#">Categories</a></li>
                                            <li><a href="#">Coupons</a></li>
                                            <li><a href="#">Orders</a></li>
                                            <li><a href="#">Customers</a></li>
                                            <li><a href="#">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-block">
                        <p><i class="fi-rs-smartphone"></i><span>Toll Free</span> (+1) 0000-000-000 </p>
                    </div>
                    <p class="mobile-promotion">Happy <span class="text-brand">Mother's Day</span>. Big Sale Up to 40%
                    </p>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ route('wishlist') }}">
                                    <img alt="DraftScripts"
                                        src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}">
                                    <span class="pro-count white">4</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('cart') }}">
                                    <img alt="DraftScripts"
                                        src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}">
                                    <span class="pro-count white">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="product-details.html"><img alt="DraftScripts"
                                                        src="{{ asset('assets/imgs/shop/thumbnail-3.jpg') }}"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="product-details.html">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="product-details.html"><img alt="DraftScripts"
                                                        src="{{ asset('assets/imgs/shop/thumbnail-4.jpg') }}"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="product-details.html">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{ route('cart') }}">View cart</a>
                                            <a href="{{ route('checkout') }}">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header-action-icon-2 d-block d-lg-none">
                                <div class="burger-icon burger-icon-white">
                                    <span class="burger-icon-top"></span>
                                    <span class="burger-icon-mid"></span>
                                    <span class="burger-icon-bottom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/imgs/logo/logo.png') }}" alt="logo">
                    </a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…">
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <div class="main-categori-wrap mobile-header-border">
                        <a class="categori-button-active-2" href="#">
                            <span class="fi-rs-apps"></span> Browse Categories
                        </a>
                        <div class="categori-dropdown-wrap categori-dropdown-active-small">
                            <ul>
                                @foreach ($this->categories as $category)
                                    <li>
                                        <a href="{{ route('shop', ['category' => $category->slug]) }}">
                                            {{-- Todo: Category icon  --}}
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                    {{-- Limit to 10 categories --}}
                                    @break($loop->iteration == 10)
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li class="menu-item-has-children">
                                <span class="menu-expand"></span>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="menu-expand"></span>
                                <a href="{{ route('shop') }}">shop</a>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="menu-expand"></span>
                                <a href="{{ route('shop') }}">Our Collections</a>
                                <ul class="dropdown">
                                    @foreach ($this->categories as $category)
                                        <li class="menu-item-has-children">
                                            <span class="menu-expand"></span>
                                            <a href="#">{{ $category->name }}</a>
                                            <ul class="dropdown">
                                                @foreach ($category->children as $subcategory)
                                                    <li>
                                                        <a href="product-details.html">{{ $subcategory->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="menu-expand"></span>
                                <a href="{{ route('blog') }}">Blog</a>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="menu-expand"></span>
                                <a href="#">Language</a>
                                <ul class="dropdown">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">German</a></li>
                                    <li><a href="#">Spanish</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap mobile-header-border">
                    <div class="single-mobile-header-info mt-30">
                        <a href="contact.html"> Our location </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="login.html">Log In </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="register.html">Sign Up</a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#">(+1) 0000-000-000 </a>
                    </div>
                </div>
                <div class="mobile-social-icon">
                    <h5 class="mb-15 text-grey-4">Follow Us</h5>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-twitter.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-youtube.svg') }}"
                            alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>

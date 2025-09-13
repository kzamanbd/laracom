<div>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Your Cart
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if ($this->cartItems->count() > 0)
                            <div class="table-responsive">
                                <table class="table shopping-summery text-center clean">
                                    <thead>
                                        <tr class="main-heading">
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($this->cartItems as $cartItem)
                                            <tr>
                                                <td class="image product-thumbnail">
                                                    <img src="{{ $cartItem->product->thumbnail_path }}"
                                                        alt="{{ $cartItem->product_name }}">
                                                </td>
                                                <td class="product-des product-name text-start">
                                                    <h5 class="product-name">
                                                        <a href="{{ $this->getProductUrl($cartItem->product) }}">
                                                            {{ $cartItem->product_name }}
                                                        </a>
                                                    </h5>
                                                    @if ($cartItem->product->description)
                                                        <p class="font-xs">
                                                            {{ Str::limit($cartItem->product->description, 80) }}</p>
                                                    @endif
                                                    @if ($cartItem->product_sku)
                                                        <small class="text-muted">SKU:
                                                            {{ $cartItem->product_sku }}</small>
                                                    @endif
                                                </td>
                                                <td class="price" data-title="Price">
                                                    <span>{{ formatPrice($cartItem->unit_price) }}</span>
                                                </td>
                                                <td class="text-center" data-title="Stock">
                                                    <div class="detail-qty border radius m-auto">
                                                        <a href="#"
                                                            wire:click="decrementQuantity({{ $cartItem->id }})"
                                                            wire:loading.attr="disabled"
                                                            wire:target="decrementQuantity,updateQuantity"
                                                            class="qty-down">
                                                            <i class="fi-rs-angle-small-down"></i>
                                                        </a>
                                                        <span class="qty-val" wire:loading.class="opacity-50"
                                                            wire:target="updateQuantity">
                                                            {{ $cartItem->quantity }}
                                                        </span>
                                                        <a href="#"
                                                            wire:click="incrementQuantity({{ $cartItem->id }})"
                                                            wire:loading.attr="disabled"
                                                            wire:target="incrementQuantity,updateQuantity"
                                                            class="qty-up">
                                                            <i class="fi-rs-angle-small-up"></i>
                                                        </a>
                                                    </div>
                                                    <div wire:loading wire:target="updateQuantity"
                                                        class="text-center mt-1">
                                                        <small class="text-muted">Updating...</small>
                                                    </div>
                                                </td>
                                                <td class="text-right" data-title="Cart">
                                                    <span wire:loading.class="opacity-50" wire:target="updateQuantity">
                                                        {{ $this->getSubtotal($cartItem) }}
                                                    </span>
                                                </td>
                                                <td class="action" data-title="Remove">
                                                    <a href="#" wire:click="removeItem({{ $cartItem->id }})"
                                                        wire:confirm="Are you sure you want to remove this item?"
                                                        wire:loading.attr="disabled" wire:target="removeItem"
                                                        class="text-muted">
                                                        <i class="fi-rs-trash" wire:loading.remove
                                                            wire:target="removeItem"></i>
                                                        <i class="fi-rs-loading" wire:loading
                                                            wire:target="removeItem"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6" class="text-end">
                                                <a href="#" wire:click="clearCart"
                                                    wire:confirm="Are you sure you want to clear your cart?"
                                                    wire:loading.attr="disabled" wire:target="clearCart"
                                                    class="text-muted">
                                                    <i class="fi-rs-cross-small"></i> Clear Cart
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-action text-end">
                                <a href="{{ route('shop') }}" class="btn mr-10 mb-sm-15">
                                    <i class="fi-rs-shopping-bag mr-10"></i>Continue Shopping
                                </a>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <img src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}" alt="Empty Cart"
                                    class="mb-3" style="width: 80px; opacity: 0.5;">
                                <h4>Your cart is empty</h4>
                                <p class="text-muted my-2">Looks like you haven't added anything to your cart yet</p>
                                <a href="{{ route('shop') }}" class="btn">Start Shopping</a>
                            </div>
                        @endif

                        @if ($this->cartItems->count() > 0)
                            <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                            <div class="row mb-50">
                                <div class="col-lg-6 col-md-12">
                                    <div class="heading_s1 mb-3">
                                        <h4>Calculate Shipping</h4>
                                    </div>
                                    <p class="mt-15 mb-30">Flat rate: <span class="font-xl text-brand fw-900">5%</span>
                                    </p>
                                    <form class="field_form shipping_calculator">
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <div class="custom_select">
                                                    <select class="form-control select-active">
                                                        <option value="">Choose a country...</option>
                                                        <option value="US">United States</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="GB">United Kingdom</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="FR">France</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="IN">India</option>
                                                        <option value="CN">China</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row row">
                                            <div class="form-group col-lg-6">
                                                <input required="required" placeholder="State / Province"
                                                    name="state" type="text">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input required="required" placeholder="PostCode / ZIP"
                                                    name="zip" type="text">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <button type="button" class="btn btn-sm">
                                                    <i class="fi-rs-shuffle mr-10"></i>Update Shipping
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <livewire:storefront.cart.totals />
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </section>
    </main>
</div>

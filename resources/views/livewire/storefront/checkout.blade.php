<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Home</a>
                <span></span> Shop
                <span></span> Checkout
            </div>
        </div>
    </div>

    <section class="mt-50 mb-50">
        <div class="container">

            <!-- Coupon Section -->
            <div class="row">
                <div class="col-lg-6 mb-sm-15">
                    @guest
                        <div class="toggle_info">
                            <span>
                                <i class="fi-rs-user mr-10"></i>
                                <span class="text-muted">Already have an account?</span>
                                <a href="{{ route('login') }}">Click here to login</a>
                            </span>
                        </div>
                    @endguest

                    <div class="toggle_info mt-15">
                        <span>
                            <i class="fi-rs-label mr-10"></i>
                            <span class="text-muted">Have a coupon?</span>
                            <a href="#coupon" data-bs-toggle="collapse">Click here to enter your code</a>
                        </span>
                    </div>
                    <div class="panel-collapse collapse coupon_form" id="coupon">
                        <div class="panel-body">
                            <p class="mb-30 font-sm">If you have a coupon code, please apply it below.</p>
                            <form wire:submit="applyCoupon">
                                <div class="form-group">
                                    <input type="text" wire:model="form.coupon_code"
                                        placeholder="Enter Coupon Code...">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md">Apply Coupon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="divider mt-50 mb-50"></div>
                </div>
            </div>

            <!-- Checkout Form -->
            <form wire:submit="placeOrder">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-25">
                            <h4>Billing Details</h4>
                        </div>

                        <!-- Billing Address Form -->
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_first_name" placeholder="First name *"
                                required>
                            @error('form.billing_first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_last_name" placeholder="Last name *"
                                required>
                            @error('form.billing_last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_company" placeholder="Company Name">
                        </div>
                        <div class="form-group">
                            <select wire:model="form.billing_country" class="form-control" required>
                                <option value="">Select a country...</option>
                                @foreach ($this->countries as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('form.billing_country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_address_line_1" placeholder="Address *"
                                required>
                            @error('form.billing_address_line_1')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_address_line_2" placeholder="Address line 2">
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_city" placeholder="City / Town *" required>
                            @error('form.billing_city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_state" placeholder="State / County">
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model="form.billing_postal_code" placeholder="Postcode / ZIP">
                        </div>
                        <div class="form-group">
                            <input type="tel" wire:model="form.billing_phone" placeholder="Phone">
                        </div>
                        <div class="form-group">
                            <input type="email" wire:model="form.billing_email" placeholder="Email address *"
                                required>
                            @error('form.billing_email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        @guest
                            <!-- Create Account Option -->
                            <div class="form-group">
                                <div class="checkbox">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox"
                                            wire:model.live="form.create_account" id="createaccount">
                                        <label class="form-check-label" for="createaccount">
                                            <span>Create an account?</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if ($form->create_account)
                                <div class="form-group">
                                    <input type="password" wire:model="form.account_password"
                                        placeholder="Account Password *" required>
                                    @error('form.account_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        @endguest

                        <!-- Different Shipping Address -->
                        <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox"
                                            wire:model.live="form.ship_to_different_address" id="differentaddress">
                                        <label class="form-check-label" for="differentaddress">
                                            <span>Ship to a different address?</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if ($form->ship_to_different_address)
                                <div class="different_address">
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_first_name"
                                            placeholder="First name *" required>
                                        @error('form.shipping_first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_last_name"
                                            placeholder="Last name *" required>
                                        @error('form.shipping_last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_company"
                                            placeholder="Company Name">
                                    </div>
                                    <div class="form-group">
                                        <select wire:model="form.shipping_country" class="form-control" required>
                                            <option value="">Select a country...</option>
                                            @foreach ($this->countries as $code => $name)
                                                <option value="{{ $code }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.shipping_country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_address_line_1"
                                            placeholder="Address *" required>
                                        @error('form.shipping_address_line_1')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_address_line_2"
                                            placeholder="Address line 2">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_city"
                                            placeholder="City / Town *" required>
                                        @error('form.shipping_city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_state"
                                            placeholder="State / County">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" wire:model="form.shipping_postal_code"
                                            placeholder="Postcode / ZIP">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Order Notes -->
                        <div class="mb-20">
                            <h5>Additional information</h5>
                        </div>
                        <div class="form-group mb-30">
                            <textarea wire:model="form.customer_note" rows="5" placeholder="Order notes"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="order_review">
                            <div class="mb-20">
                                <h4>Your Order</h4>
                            </div>

                            <!-- Order Summary -->
                            <div class="table-responsive order_table text-center">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($this->cartItems as $item)
                                            <tr>
                                                <td class="image product-thumbnail">
                                                    <img src="{{ $item->product->thumbnail_path }}"
                                                        alt="{{ $item->product_name }}">
                                                </td>
                                                <td>
                                                    <h5>{{ $item->product_name }}</h5>
                                                    <span class="product-qty">x {{ $item->quantity }}</span>
                                                </td>
                                                <td>{{ formatPrice($item->total_price) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">Your cart is empty</td>
                                            </tr>
                                        @endforelse

                                        <tr>
                                            <th>SubTotal</th>
                                            <td class="product-subtotal" colspan="2">
                                                {{ formatPrice($this->cart->subtotal) }}
                                            </td>
                                        </tr>

                                        @if ($this->cart->coupon_discount > 0)
                                            <tr>
                                                <th>Discount</th>
                                                <td colspan="2">
                                                    -{{ formatPrice($this->cart->coupon_discount) }}
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($this->cart->tax_total > 0)
                                            <tr>
                                                <th>Tax</th>
                                                <td colspan="2">{{ formatPrice($this->cart->tax_total) }}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th>Shipping</th>
                                            <td colspan="2">
                                                @if ($this->cart->shipping_total > 0)
                                                    {{ formatPrice($this->cart->shipping_total) }}
                                                @else
                                                    <em>Free Shipping</em>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Total</th>
                                            <td colspan="2" class="product-subtotal">
                                                <span class="font-xl text-brand fw-900">
                                                    {{ formatPrice($this->cart->total) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="bt-1 border-color-1 mt-30 mb-30"></div>

                            <!-- Payment Method -->
                            <div class="payment_method">
                                <div class="mb-25">
                                    <h5>Payment</h5>
                                </div>
                                <div class="payment_option">
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio"
                                            wire:model="form.payment_method" value="cash_on_delivery"
                                            id="cashOnDelivery">
                                        <label class="form-check-label" for="cashOnDelivery">Cash On
                                            Delivery</label>
                                    </div>
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio"
                                            wire:model="form.payment_method" value="card_payment" id="cardPayment">
                                        <label class="form-check-label" for="cardPayment">Card Payment</label>
                                    </div>
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio"
                                            wire:model="form.payment_method" value="paypal" id="paypal">
                                        <label class="form-check-label" for="paypal">PayPal</label>
                                    </div>
                                </div>
                                @error('form.payment_method')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" class="btn btn-fill-out btn-block mt-30"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>Place Order</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

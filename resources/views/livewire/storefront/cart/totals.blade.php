<div class="border p-md-4 p-30 border-radius cart-totals">
    <div class="heading_s1 mb-3">
        <h4>Cart Totals</h4>
    </div>

    @if (session('coupon_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('coupon_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('coupon_error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('coupon_error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td class="cart_total_label">Cart Subtotal</td>
                    <td class="cart_total_amount">
                        <span class="font-lg fw-900 text-brand">{{ formatPrice($this->cart->subtotal) }}</span>
                    </td>
                </tr>
                @if ($this->cart->shipping_cost > 0)
                    <tr>
                        <td class="cart_total_label">Shipping</td>
                        <td class="cart_total_amount">
                            <span>{{ formatPrice($this->cart->shipping_cost) }}</span>
                        </td>
                    </tr>
                @endif
                @if ($this->cart->tax_total > 0)
                    <tr>
                        <td class="cart_total_label">Tax</td>
                        <td class="cart_total_amount">
                            <span>{{ formatPrice($this->cart->tax_total) }}</span>
                        </td>
                    </tr>
                @endif
                @if ($this->cart->coupon_discount > 0)
                    <tr>
                        <td class="cart_total_label">
                            Discount
                            @if ($this->cart->coupon_code)
                                <span class="badge bg-success">{{ $this->cart->coupon_code }}</span>
                                <a href="#" wire:click="removeCoupon" class="text-danger ms-2"
                                    title="Remove coupon">
                                    <i class="fi-rs-cross-small"></i>
                                </a>
                            @endif
                        </td>
                        <td class="cart_total_amount">
                            <span class="text-success">-{{ formatPrice($this->cart->coupon_discount) }}</span>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="cart_total_label">
                        <strong>Total</strong>
                    </td>
                    <td class="cart_total_amount">
                        <strong class="font-xl fw-900 text-brand">{{ formatPrice($this->cart->total) }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Coupon Code Section -->
    @if (!$this->cart->coupon_code)
        <div class="mb-30 mt-30">
            <div class="heading_s1 mb-3">
                <h6>Apply Coupon</h6>
            </div>
            <form wire:submit.prevent="applyCoupon">
                <div class="d-flex">
                    <input wire:model="couponCode" type="text" placeholder="Enter coupon code"
                        class="form-control me-2" @error('couponCode') is-invalid @enderror>
                    <button type="submit" wire:loading.attr="disabled" wire:target="applyCoupon" class="btn btn-sm">
                        <span wire:loading.remove wire:target="applyCoupon">Apply</span>
                        <span wire:loading wire:target="applyCoupon">
                            <i class="fi-rs-loading"></i> Applying...
                        </span>
                    </button>
                </div>
                @error('couponCode')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </form>
        </div>
    @endif

    <a href="{{ $this->getCheckoutUrl() }}" class="btn btn-block">
        <i class="fi-rs-box-alt mr-10"></i> Proceed To CheckOut
    </a>
</div>

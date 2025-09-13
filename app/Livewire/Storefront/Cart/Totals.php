<?php

namespace App\Livewire\Storefront\Cart;

class Totals extends CartBase
{
    public string $couponCode = '';

    public bool $applyingCoupon = false;

    /**
     * Apply coupon code
     */
    public function applyCoupon(): void
    {
        $this->validate([
            'couponCode' => 'required|string|min:3|max:50',
        ]);

        $this->applyingCoupon = true;

        $success = $this->getCartService()->applyCoupon($this->couponCode);

        if ($success) {
            $this->dispatchCartUpdated('Coupon applied successfully!');
            $this->couponCode = '';
        } else {
            session()->flash('coupon_error', 'Invalid coupon code. Please try again.');
        }

        $this->applyingCoupon = false;
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon(): void
    {
        $this->getCartService()->removeCoupon();
        $this->dispatchCartUpdated('Coupon removed successfully!');
    }

    /**
     * Get checkout URL
     */
    public function getCheckoutUrl(): string
    {
        return route('checkout');
    }

    public function render()
    {
        return view('livewire.storefront.cart.totals', [
            'cart' => $this->cart(),
        ]);
    }
}

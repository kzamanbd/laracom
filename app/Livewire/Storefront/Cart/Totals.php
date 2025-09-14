<?php

namespace App\Livewire\Storefront\Cart;

use Livewire\Attributes\Validate;

class Totals extends CartBase
{
    #[Validate('required|string|min:3|max:50')]
    public string $couponCode = '';

    public bool $applyingCoupon = false;

    /**
     * Apply coupon code
     */
    public function applyCoupon(): void
    {
        $this->applyingCoupon = true;

        $success = $this->getCartService()->applyCoupon($this->couponCode);

        if ($success) {
            $this->dispatchCartUpdated('Coupon applied successfully!');
            $this->couponCode = '';
        } else {
            $this->dispatch('toast', 'Invalid coupon code. Please try again.', 'error');
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

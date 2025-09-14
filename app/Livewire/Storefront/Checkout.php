<?php

namespace App\Livewire\Storefront;

use App\Livewire\Storefront\Forms\CheckoutForm;
use App\Models\Cart\Cart;
use App\Services\Cart\CartService;
use App\Services\Orders\OrderService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.storefront', ['title' => 'Checkout'])]
class Checkout extends Component
{
    public CheckoutForm $form;

    public bool $processing = false;

    public string $title = 'Checkout';

    protected CartService $cartService;

    protected OrderService $orderService;

    public function boot(): void
    {
        $this->cartService = app(CartService::class);
        $this->orderService = app(OrderService::class);
    }

    public function mount(): void
    {
        // Set default country values
        $this->form->billing_country = 'US';
        $this->form->shipping_country = 'US';

        // Pre-fill form with authenticated user data if available
        $this->form->fillWithUserData();

        // Auto-enable save address checkboxes for logged-in users
        if (auth()->check()) {
            $this->form->save_billing_address = true;
            $this->form->save_shipping_address = true;
        }
    }

    public function getCartProperty(): Cart
    {
        return $this->cartService->getCurrentCart();
    }

    public function getCartItemsProperty()
    {
        return $this->cart->items()->with('product.thumbnail')->get();
    }

    public function getCountriesProperty(): array
    {
        return [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'NL' => 'Netherlands',
            'BE' => 'Belgium',
            'CH' => 'Switzerland',
            'AT' => 'Austria',
            'SE' => 'Sweden',
            'NO' => 'Norway',
            'DK' => 'Denmark',
            'FI' => 'Finland',
            'PL' => 'Poland',
            'CZ' => 'Czech Republic',
            'HU' => 'Hungary',
        ];
    }

    public function updatedFormShipToDifferentAddress(): void
    {
        if (! $this->form->ship_to_different_address) {
            // Copy billing address to shipping when unchecked
            $this->form->copyBillingToShipping();
        }
    }

    public function applyCoupon(): void
    {
        if (empty($this->form->coupon_code)) {
            return;
        }

        $success = $this->cartService->applyCoupon($this->form->coupon_code);

        if ($success) {
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Coupon applied successfully!',
            ]);
            $this->form->clearCouponCode();
            $this->dispatch('cart-updated');
        } else {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Invalid coupon code',
            ]);
        }
    }

    public function placeOrder(): void
    {
        $this->processing = true;

        try {
            $this->form->validate();

            // Check if cart is empty
            if ($this->cart->isEmpty()) {
                $this->dispatch('toast', [
                    'type' => 'error',
                    'message' => 'Your cart is empty',
                ]);
                $this->processing = false;

                return;
            }

            // Get checkout data from form
            $checkoutData = $this->form->getCheckoutData();

            // Create order
            $order = $this->orderService->createFromCart($this->cart, $checkoutData);

            // Process payment
            $paymentData = [
                'payment_method' => $this->form->payment_method,
            ];

            $paymentSuccess = $this->orderService->processPayment($order, $paymentData);

            if ($paymentSuccess) {
                $this->dispatch('toast', [
                    'type' => 'success',
                    'message' => 'Order placed successfully!',
                ]);
                $this->redirect(route('order.confirmation', $order->id));
            } else {
                $this->dispatch('toast', [
                    'type' => 'error',
                    'message' => 'Payment processing failed. Please try again.',
                ]);
            }
        } catch (ValidationException $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Please fix the errors below',
            ]);
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'An error occurred while processing your order. Please try again.',
            ]);
            Log::error('Checkout error: '.$e->getMessage(), [
                'user_id' => auth()->id(),
                'cart_id' => $this->cart->id,
                'trace' => $e->getTraceAsString(),
            ]);
        } finally {
            $this->processing = false;
        }
    }

    public function render()
    {
        return view('livewire.storefront.checkout');
    }
}

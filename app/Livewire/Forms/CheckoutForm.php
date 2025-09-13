<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutForm extends Form
{
    // Billing address properties
    #[Validate('required|string|max:255')]
    public string $billing_first_name = '';

    #[Validate('required|string|max:255')]
    public string $billing_last_name = '';

    #[Validate('required|email|max:255')]
    public string $billing_email = '';

    #[Validate('nullable|string|max:255')]
    public string $billing_company = '';

    #[Validate('nullable|string|max:20')]
    public string $billing_phone = '';

    #[Validate('required|string|max:255')]
    public string $billing_address_line_1 = '';

    #[Validate('nullable|string|max:255')]
    public string $billing_address_line_2 = '';

    #[Validate('required|string|max:255')]
    public string $billing_city = '';

    #[Validate('nullable|string|max:255')]
    public string $billing_state = '';

    #[Validate('nullable|string|max:20')]
    public string $billing_postal_code = '';

    #[Validate('required|string|size:2')]
    public string $billing_country = '';

    // Shipping address properties
    #[Validate('required_if:ship_to_different_address,true|string|max:255')]
    public string $shipping_first_name = '';

    #[Validate('required_if:ship_to_different_address,true|string|max:255')]
    public string $shipping_last_name = '';

    #[Validate('nullable|string|max:255')]
    public string $shipping_company = '';

    #[Validate('required_if:ship_to_different_address,true|string|max:255')]
    public string $shipping_address_line_1 = '';

    #[Validate('nullable|string|max:255')]
    public string $shipping_address_line_2 = '';

    #[Validate('required_if:ship_to_different_address,true|string|max:255')]
    public string $shipping_city = '';

    #[Validate('nullable|string|max:255')]
    public string $shipping_state = '';

    #[Validate('nullable|string|max:20')]
    public string $shipping_postal_code = '';

    #[Validate('required_if:ship_to_different_address,true|string|size:2')]
    public string $shipping_country = '';

    // Other form properties
    public bool $ship_to_different_address = false;

    #[Validate('required|in:cash_on_delivery,card_payment,paypal')]
    public string $payment_method = '';

    #[Validate('nullable|string|max:1000')]
    public string $customer_note = '';

    #[Validate('nullable|string|max:50')]
    public string $coupon_code = '';

    public bool $create_account = false;

    #[Validate('required_if:create_account,true|min:8')]
    public string $account_password = '';

    /**
     * Fill the form with authenticated user data.
     */
    public function fillWithUserData(): void
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->billing_email = $user->email;

            if ($user->name) {
                $nameParts = explode(' ', $user->name, 2);
                $this->billing_first_name = $nameParts[0] ?? '';
                $this->billing_last_name = $nameParts[1] ?? '';
            }
        }
    }

    /**
     * Copy billing address to shipping address.
     */
    public function copyBillingToShipping(): void
    {
        $this->shipping_first_name = $this->billing_first_name;
        $this->shipping_last_name = $this->billing_last_name;
        $this->shipping_company = $this->billing_company;
        $this->shipping_address_line_1 = $this->billing_address_line_1;
        $this->shipping_address_line_2 = $this->billing_address_line_2;
        $this->shipping_city = $this->billing_city;
        $this->shipping_state = $this->billing_state;
        $this->shipping_postal_code = $this->billing_postal_code;
        $this->shipping_country = $this->billing_country ?: 'US';
    }

    /**
     * Get billing address data as array.
     */
    public function getBillingData(): array
    {
        return [
            'first_name' => $this->billing_first_name,
            'last_name' => $this->billing_last_name,
            'email' => $this->billing_email,
            'company' => $this->billing_company,
            'phone' => $this->billing_phone,
            'address_line_1' => $this->billing_address_line_1,
            'address_line_2' => $this->billing_address_line_2,
            'city' => $this->billing_city,
            'state' => $this->billing_state,
            'postal_code' => $this->billing_postal_code,
            'country' => $this->billing_country,
        ];
    }

    /**
     * Get shipping address data as array.
     */
    public function getShippingData(): array
    {
        return [
            'first_name' => $this->shipping_first_name,
            'last_name' => $this->shipping_last_name,
            'company' => $this->shipping_company,
            'address_line_1' => $this->shipping_address_line_1,
            'address_line_2' => $this->shipping_address_line_2,
            'city' => $this->shipping_city,
            'state' => $this->shipping_state,
            'postal_code' => $this->shipping_postal_code,
            'country' => $this->shipping_country,
        ];
    }

    /**
     * Get complete checkout data array.
     */
    public function getCheckoutData(): array
    {
        $data = [
            'billing' => $this->getBillingData(),
            'ship_to_different_address' => $this->ship_to_different_address,
            'payment_method' => $this->payment_method,
            'customer_note' => $this->customer_note,
        ];

        if ($this->ship_to_different_address) {
            $data['shipping'] = $this->getShippingData();
        }

        return $data;
    }

    /**
     * Clear the coupon code after application.
     */
    public function clearCouponCode(): void
    {
        $this->coupon_code = '';
    }
}

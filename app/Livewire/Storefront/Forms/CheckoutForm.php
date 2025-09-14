<?php

namespace App\Livewire\Storefront\Forms;

use App\Models\Core\Address;
use App\Models\Core\Customer;
use App\Models\User;
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

    public bool $save_billing_address = false;

    public bool $save_shipping_address = false;

    /**
     * Fill the form with authenticated user data.
     */
    public function fillWithUserData(): void
    {
        if (auth()->check()) {
            $user = auth()->user();
            $customer = $user->customer()->first();

            $this->billing_email = $user->email;

            if ($user->name) {
                $nameParts = explode(' ', $user->name, 2);
                $this->billing_first_name = $nameParts[0] ?? '';
                $this->billing_last_name = $nameParts[1] ?? '';
            }

            // Pre-fill with default addresses if available
            if ($customer) {
                $this->fillWithDefaultAddresses($customer);
            }
        }
    }

    /**
     * Fill form with customer's default addresses.
     */
    public function fillWithDefaultAddresses(Customer $customer): void
    {
        // Fill billing address with default billing address
        if ($customer->defaultBillingAddress) {
            $billing = $customer->defaultBillingAddress;
            $this->billing_first_name = $billing->name ? explode(' ', $billing->name)[0] : '';
            $this->billing_last_name = $billing->name ? (explode(' ', $billing->name)[1] ?? '') : '';
            $this->billing_company = $billing->company ?? '';
            $this->billing_phone = $billing->phone ?? '';
            $this->billing_address_line_1 = $billing->line1;
            $this->billing_address_line_2 = $billing->line2 ?? '';
            $this->billing_city = $billing->city;
            $this->billing_state = $billing->state ?? '';
            $this->billing_postal_code = $billing->postal_code ?? '';
            $this->billing_country = $billing->country;
        }

        // Fill shipping address with default shipping address
        if ($customer->defaultShippingAddress) {
            $shipping = $customer->defaultShippingAddress;
            $this->shipping_first_name = $shipping->name ? explode(' ', $shipping->name)[0] : '';
            $this->shipping_last_name = $shipping->name ? (explode(' ', $shipping->name)[1] ?? '') : '';
            $this->shipping_company = $shipping->company ?? '';
            $this->shipping_address_line_1 = $shipping->line1;
            $this->shipping_address_line_2 = $shipping->line2 ?? '';
            $this->shipping_city = $shipping->city;
            $this->shipping_state = $shipping->state ?? '';
            $this->shipping_postal_code = $shipping->postal_code ?? '';
            $this->shipping_country = $shipping->country;

            // If shipping address is different, set the flag
            if (! $this->addressesAreIdentical($customer->defaultBillingAddress, $customer->defaultShippingAddress)) {
                $this->ship_to_different_address = true;
            }
        }
    }

    /**
     * Check if two addresses are identical.
     */
    protected function addressesAreIdentical(?Address $billing, ?Address $shipping): bool
    {
        if (! $billing || ! $shipping) {
            return false;
        }

        return $billing->line1 === $shipping->line1 &&
            $billing->line2 === $shipping->line2 &&
            $billing->city === $shipping->city &&
            $billing->state === $shipping->state &&
            $billing->postal_code === $shipping->postal_code &&
            $billing->country === $shipping->country;
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
            'create_account' => $this->create_account,
            'account_password' => $this->account_password,
            'save_billing_address' => $this->save_billing_address,
            'save_shipping_address' => $this->save_shipping_address,
        ];

        if ($this->ship_to_different_address) {
            $data['shipping'] = $this->getShippingData();
        }

        return $data;
    }

    /**
     * Create user account for guest checkout.
     */
    public function createGuestAccount(): ?User
    {
        if (! $this->create_account || auth()->check()) {
            return null;
        }

        return User::create([
            'name' => trim($this->billing_first_name.' '.$this->billing_last_name),
            'email' => $this->billing_email,
            'password' => bcrypt($this->account_password),
            'role' => 'customer',
            'is_active' => true,
        ]);
    }

    /**
     * Clear the coupon code after application.
     */
    public function clearCouponCode(): void
    {
        $this->coupon_code = '';
    }
}

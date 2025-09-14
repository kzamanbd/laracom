<?php

namespace App\Services\Orders;

use App\Models\Cart\Cart;
use App\Models\Core\Address;
use App\Models\Core\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create order from cart and checkout data
     */
    public function createFromCart(Cart $cart, array $checkoutData): Order
    {
        return DB::transaction(function () use ($cart, $checkoutData) {
            // Handle guest account creation if requested
            $user = $this->handleGuestAccountCreation($checkoutData);

            // Create or get customer
            $customer = $this->createCustomer($checkoutData, $user);

            // Create billing address
            $billingAddress = $this->createBillingAddress($customer, $checkoutData['billing']);

            // Create shipping address (if different from billing)
            $shippingAddress = $this->createShippingAddress(
                $customer,
                $checkoutData['shipping'] ?? $checkoutData['billing'],
                $checkoutData['ship_to_different_address'] ?? false
            );

            // Set addresses as default if requested
            $this->handleDefaultAddresses($customer, $billingAddress, $shippingAddress, $checkoutData);

            // Create order
            $order = Order::create([
                'number' => Order::generateOrderNumber(),
                'customer_id' => $customer->id,
                'user_id' => $user?->id ?? auth()->id(),
                'status' => 'pending',
                'currency' => $cart->currency,
                'subtotal' => $cart->subtotal,
                'discount_total' => $cart->discount_total,
                'tax_total' => $cart->tax_total,
                'shipping_total' => $cart->shipping_total,
                'total' => $cart->total,
                'payment_status' => 'unpaid',
                'billing_address_id' => $billingAddress->id,
                'shipping_address_id' => $shippingAddress->id,
                'customer_note' => $checkoutData['customer_note'] ?? null,
                'placed_at' => now(),
                'meta' => [
                    'payment_method' => $checkoutData['payment_method'] ?? null,
                    'coupon_code' => $cart->coupon_code,
                    'guest_account_created' => isset($checkoutData['create_account']) && $checkoutData['create_account'],
                ],
            ]);

            // Create order items from cart items
            $this->createOrderItems($order, $cart);

            // Mark cart as converted
            $cart->markAsConverted();

            // Auto-login if guest account was created
            if ($user && ! Auth::check()) {
                Auth::login($user);
            }

            return $order;
        });
    }

    /**
     * Handle guest account creation if requested
     */
    protected function handleGuestAccountCreation(array $checkoutData): ?User
    {
        if (! isset($checkoutData['create_account']) || ! $checkoutData['create_account'] || auth()->check()) {
            return auth()->user();
        }

        // Create new user account
        return User::create([
            'name' => trim($checkoutData['billing']['first_name'].' '.$checkoutData['billing']['last_name']),
            'email' => $checkoutData['billing']['email'],
            'password' => bcrypt($checkoutData['account_password']),
            'role' => 'customer',
            'is_active' => true,
        ]);
    }

    /**
     * Create or get customer from checkout data
     */
    protected function createCustomer(array $checkoutData, ?User $user = null): Customer
    {
        $customerData = [
            'first_name' => $checkoutData['billing']['first_name'],
            'last_name' => $checkoutData['billing']['last_name'],
            'email' => $checkoutData['billing']['email'],
            'phone' => $checkoutData['billing']['phone'] ?? null,
        ];

        return Customer::createFromCheckout($customerData, $user);
    }

    /**
     * Handle setting addresses as default if requested
     */
    protected function handleDefaultAddresses(
        Customer $customer,
        Address $billingAddress,
        Address $shippingAddress,
        array $checkoutData
    ): void {
        // Set billing address as default if requested or if customer has no default billing address
        if (isset($checkoutData['save_billing_address']) && $checkoutData['save_billing_address'] || ! $customer->default_billing_address_id) {
            $billingAddress->setAsDefault();
            $customer->update(['default_billing_address_id' => $billingAddress->id]);
        }

        // Set shipping address as default if requested or if customer has no default shipping address
        if (isset($checkoutData['save_shipping_address']) && $checkoutData['save_shipping_address'] || ! $customer->default_shipping_address_id) {
            $shippingAddress->setAsDefault();
            $customer->update(['default_shipping_address_id' => $shippingAddress->id]);
        }
    }

    /**
     * Create billing address
     */
    protected function createBillingAddress(Customer $customer, array $billingData): Address
    {
        $addressData = [
            'name' => trim(($billingData['first_name'] ?? '').' '.($billingData['last_name'] ?? '')),
            'company' => $billingData['company'] ?? null,
            'phone' => $billingData['phone'] ?? null,
            'line1' => $billingData['address_line_1'],
            'line2' => $billingData['address_line_2'] ?? null,
            'city' => $billingData['city'],
            'state' => $billingData['state'] ?? null,
            'postal_code' => $billingData['postal_code'] ?? null,
            'country' => $billingData['country'],
        ];

        return Address::createFromForm($addressData, $customer, 'billing');
    }

    /**
     * Create shipping address
     */
    protected function createShippingAddress(
        Customer $customer,
        array $shippingData,
        bool $isDifferent = false
    ): Address {
        $addressData = [
            'name' => trim(($shippingData['first_name'] ?? '').' '.($shippingData['last_name'] ?? '')),
            'company' => $shippingData['company'] ?? null,
            'phone' => $shippingData['phone'] ?? null,
            'line1' => $shippingData['address_line_1'],
            'line2' => $shippingData['address_line_2'] ?? null,
            'city' => $shippingData['city'],
            'state' => $shippingData['state'] ?? null,
            'postal_code' => $shippingData['postal_code'] ?? null,
            'country' => $shippingData['country'],
        ];

        return Address::createFromForm($addressData, $customer, 'shipping');
    }

    /**
     * Create order items from cart items
     */
    protected function createOrderItems(Order $order, Cart $cart): void
    {
        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'total' => $cartItem->total_price,
                'name' => $cartItem->product_name,
                'sku' => $cartItem->product_sku,
                'meta' => $cartItem->meta,
            ]);
        }
    }

    /**
     * Process payment for order
     */
    public function processPayment(Order $order, array $paymentData): bool
    {
        // This is a simplified payment processing example
        // In a real application, you would integrate with payment gateways

        $paymentMethod = $paymentData['payment_method'] ?? 'cash_on_delivery';

        switch ($paymentMethod) {
            case 'cash_on_delivery':
                // No immediate payment processing needed
                $order->update(['status' => 'processing']);

                return true;

            case 'card_payment':
                // Integrate with payment gateway (Stripe, PayPal, etc.)
                return $this->processCardPayment($order, $paymentData);

            case 'paypal':
                // Integrate with PayPal
                return $this->processPayPalPayment($order, $paymentData);

            default:
                return false;
        }
    }

    /**
     * Process card payment (placeholder)
     */
    protected function processCardPayment(Order $order, array $paymentData): bool
    {
        // This would integrate with a payment gateway like Stripe
        // For demo purposes, we'll simulate a successful payment

        $order->markAsPaid();

        return true;
    }

    /**
     * Process PayPal payment (placeholder)
     */
    protected function processPayPalPayment(Order $order, array $paymentData): bool
    {
        // This would integrate with PayPal API
        // For demo purposes, we'll simulate a successful payment

        $order->markAsPaid();

        return true;
    }

    /**
     * Cancel order
     */
    public function cancelOrder(Order $order, ?string $reason = null): bool
    {
        if (! $order->canBeCancelled()) {
            return false;
        }

        $order->update([
            'status' => 'cancelled',
            'meta' => array_merge($order->meta ?? [], [
                'cancellation_reason' => $reason,
                'cancelled_at' => now()->toISOString(),
            ]),
        ]);

        return true;
    }

    /**
     * Calculate shipping cost
     */
    public function calculateShipping(Cart $cart, array $shippingAddress): float
    {
        // This is a simplified shipping calculation
        // In a real application, you would integrate with shipping providers

        $subtotal = (float) $cart->subtotal;

        // Free shipping over $100
        if ($subtotal >= 100) {
            return 0.00;
        }

        // Flat rate shipping
        return 10.00;
    }

    /**
     * Validate checkout data
     */
    public function validateCheckoutData(array $data): array
    {
        $errors = [];

        // Validate billing address
        if (empty($data['billing']['first_name'])) {
            $errors['billing.first_name'] = 'First name is required';
        }

        if (empty($data['billing']['last_name'])) {
            $errors['billing.last_name'] = 'Last name is required';
        }

        if (empty($data['billing']['email']) || ! filter_var($data['billing']['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['billing.email'] = 'Valid email is required';
        }

        if (empty($data['billing']['address_line_1'])) {
            $errors['billing.address_line_1'] = 'Address is required';
        }

        if (empty($data['billing']['city'])) {
            $errors['billing.city'] = 'City is required';
        }

        if (empty($data['billing']['country'])) {
            $errors['billing.country'] = 'Country is required';
        }

        // Validate shipping address if different
        if (! empty($data['ship_to_different_address'])) {
            if (empty($data['shipping']['first_name'])) {
                $errors['shipping.first_name'] = 'Shipping first name is required';
            }

            if (empty($data['shipping']['last_name'])) {
                $errors['shipping.last_name'] = 'Shipping last name is required';
            }

            if (empty($data['shipping']['address_line_1'])) {
                $errors['shipping.address_line_1'] = 'Shipping address is required';
            }

            if (empty($data['shipping']['city'])) {
                $errors['shipping.city'] = 'Shipping city is required';
            }

            if (empty($data['shipping']['country'])) {
                $errors['shipping.country'] = 'Shipping country is required';
            }
        }

        // Validate payment method
        if (empty($data['payment_method'])) {
            $errors['payment_method'] = 'Please select a payment method';
        }

        return $errors;
    }
}

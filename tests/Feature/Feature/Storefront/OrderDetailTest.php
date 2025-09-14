<?php

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'customer']);
    $this->customer = Customer::factory()->create(['user_id' => $this->user->id]);
});

test('authenticated customer can view their order details', function () {
    $order = Order::factory()->for($this->user)->create();
    $product = Product::factory()->for($this->user)->create();
    OrderItem::factory()->for($order)->for($product)->create([
        'name' => $product->name,
        'sku' => $product->sku,
    ]);

    $this->actingAs($this->user)
        ->get(route('my-account.order', $order))
        ->assertSeeLivewire('storefront.my-account.order-detail')
        ->assertSee($order->number)
        ->assertSee('Order Details');
});

test('customer cannot view other customers orders', function () {
    $otherUser = User::factory()->create(['role' => 'customer']);
    $order = Order::factory()->for($otherUser)->create();

    $this->actingAs($this->user)
        ->get(route('my-account.order', $order))
        ->assertForbidden();
});

test('guest users cannot access order details', function () {
    $order = Order::factory()->for($this->user)->create();

    $this->get(route('my-account.order', $order))
        ->assertRedirect(route('login'));
});

test('order detail page displays order information correctly', function () {
    $billingAddress = Address::factory()->for($this->customer, 'addressable')->create(['type' => 'billing']);
    $shippingAddress = Address::factory()->for($this->customer, 'addressable')->create(['type' => 'shipping']);

    $order = Order::factory()->for($this->user)->create([
        'number' => 'ORD-20250913-1234',
        'status' => 'paid',
        'payment_status' => 'paid',
        'subtotal' => 100.00,
        'tax_total' => 8.50,
        'shipping_total' => 10.00,
        'total' => 118.50,
        'billing_address_id' => $billingAddress->id,
        'shipping_address_id' => $shippingAddress->id,
        'customer_note' => 'Please handle with care',
    ]);

    $product = Product::factory()->for($this->user)->create(['name' => 'Test Product', 'sku' => 'TEST-SKU-123']);
    OrderItem::factory()->for($order)->for($product)->create([
        'name' => 'Test Product',
        'sku' => 'TEST-SKU-123',
        'quantity' => 2,
        'unit_price' => 50.00,
        'total' => 100.00,
    ]);

    Livewire::actingAs($this->user)
        ->test('storefront.my-account.order-detail', ['order' => $order])
        ->assertSee('ORD-20250913-1234')
        ->assertSee('Test Product')
        ->assertSee('TEST-SKU-123')
        ->assertSee('$50.00')
        ->assertSee('$100.00')
        ->assertSee('$8.50')
        ->assertSee('$10.00')
        ->assertSee('$118.50')
        ->assertSee('Please handle with care')
        ->assertSee('Paid');
});

test('order detail page shows billing and shipping addresses', function () {
    $billingAddress = Address::factory()->for($this->customer, 'addressable')->create([
        'type' => 'billing',
        'name' => 'John Doe',
        'line1' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'postal_code' => '10001',
        'country' => 'US',
    ]);

    $shippingAddress = Address::factory()->for($this->customer, 'addressable')->create([
        'type' => 'shipping',
        'name' => 'Jane Smith',
        'line1' => '456 Oak Ave',
        'city' => 'Los Angeles',
        'state' => 'CA',
        'postal_code' => '90001',
        'country' => 'US',
    ]);

    $order = Order::factory()->for($this->user)->create([
        'billing_address_id' => $billingAddress->id,
        'shipping_address_id' => $shippingAddress->id,
    ]);

    Livewire::actingAs($this->user)
        ->test('storefront.my-account.order-detail', ['order' => $order])
        ->assertSee('Billing Address')
        ->assertSee('John Doe')
        ->assertSee('123 Main St')
        ->assertSee('New York, NY 10001')
        ->assertSee('Shipping Address')
        ->assertSee('Jane Smith')
        ->assertSee('456 Oak Ave')
        ->assertSee('Los Angeles, CA 90001');
});

test('order detail page shows payment transactions', function () {
    $order = Order::factory()->for($this->user)->create();

    PaymentTransaction::factory()->for($order)->create([
        'amount' => 118.50,
        'status' => 'succeeded',
        'provider' => 'stripe',
        'reference' => 'pi_1234567890',
    ]);

    Livewire::actingAs($this->user)
        ->test('storefront.my-account.order-detail', ['order' => $order])
        ->assertSee('Payment Information')
        ->assertSee('$118.50')
        ->assertSee('Succeeded')
        ->assertSee('via Stripe')
        ->assertSee('Ref: pi_1234567890');
});

test('customer can cancel cancellable orders', function () {
    $order = Order::factory()->for($this->user)->create([
        'status' => 'paid',
        'payment_status' => 'paid',
    ]);

    Livewire::actingAs($this->user)
        ->test('storefront.my-account.order-detail', ['order' => $order])
        ->assertSee('Cancel Order')
        ->call('cancelOrder')
        ->assertDispatched('toast', 'Order has been cancelled successfully.', 'success')
        ->assertRedirect(route('my-account', ['tab' => 'orders']));

    expect($order->fresh()->status)->toBe('cancelled');
});

test('customer cannot cancel non-cancellable orders', function () {
    $order = Order::factory()->for($this->user)->create([
        'status' => 'completed',
    ]);

    Livewire::actingAs($this->user)
        ->test('storefront.my-account.order-detail', ['order' => $order])
        ->assertDontSee('Cancel Order');
});

test('attempting to cancel non-cancellable order shows error', function () {
    $order = Order::factory()->for($this->user)->create([
        'status' => 'completed',
    ]);

    Livewire::actingAs($this->user)
        ->test('storefront.my-account.order-detail', ['order' => $order])
        ->call('cancelOrder')
        ->assertHasErrors(['order' => 'This order cannot be cancelled.']);
});

test('order detail page shows correct status badges', function () {
    $order = Order::factory()->for($this->user)->create([
        'status' => 'processing',
        'payment_status' => 'unpaid',
    ]);

    $component = Livewire::actingAs($this->user)
        ->test('storefront.my-account.order-detail', ['order' => $order]);

    expect($component->instance()->getStatusBadgeClass())->toBe('bg-warning');
    expect($component->instance()->getPaymentStatusBadgeClass())->toBe('bg-secondary');
});

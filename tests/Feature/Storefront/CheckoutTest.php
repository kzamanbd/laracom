<?php

use App\Livewire\Forms\CheckoutForm;
use App\Livewire\Storefront\Checkout;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Livewire\Livewire;

beforeEach(function () {
    $this->orderService = app(OrderService::class);
    $this->user = User::factory()->create();
});

test('checkout component can be rendered', function () {
    $response = $this->get(route('checkout'));

    $response->assertSuccessful();
    $response->assertSeeLivewire(Checkout::class);
});

test('checkout requires billing information', function () {
    Livewire::test(Checkout::class)
        ->call('placeOrder')
        ->assertHasErrors([
            'form.billing_first_name',
            'form.billing_last_name',
            'form.billing_email',
            'form.billing_address_line_1',
            'form.billing_city',
            'form.payment_method',
        ]);
});

test('can place order with valid billing information', function () {
    // Create test data
    $user = User::factory()->create();
    $product = Product::factory()->create([
        'user_id' => $user->id,
        'price' => 50.00,
        'sale_price' => null,
        'quantity' => 10,
    ]);

    // Create cart with items
    $cart = Cart::factory()->create([
        'session_id' => session()->getId(),
        'subtotal' => 50.00,
        'total' => 50.00,
        'status' => 'active',
    ]);

    CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 50.00,
        'total_price' => 50.00,
        'product_name' => $product->name,
        'product_sku' => $product->sku,
    ]);

    Livewire::test(Checkout::class)
        ->set('form.billing_first_name', 'John')
        ->set('form.billing_last_name', 'Doe')
        ->set('form.billing_email', 'john@example.com')
        ->set('form.billing_address_line_1', '123 Main St')
        ->set('form.billing_city', 'New York')
        ->set('form.billing_country', 'US')
        ->set('form.payment_method', 'cash_on_delivery')
        ->call('placeOrder')
        ->assertHasNoErrors()
        ->assertRedirect();

    // Assert order was created
    $this->assertDatabaseHas('orders', [
        'status' => 'processing',
        'payment_status' => 'unpaid',
        'subtotal' => 50.00,
        'total' => 50.00,
    ]);

    // Assert customer was created
    $this->assertDatabaseHas('customers', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
    ]);
});

test('authenticated user data is pre-filled', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $this->actingAs($user);

    Livewire::test(Checkout::class)
        ->assertSet('form.billing_first_name', 'John')
        ->assertSet('form.billing_last_name', 'Doe')
        ->assertSet('form.billing_email', 'john@example.com');
});

test('shipping address is copied from billing when not different', function () {
    Livewire::test(Checkout::class)
        ->set('form.billing_first_name', 'John')
        ->set('form.billing_last_name', 'Doe')
        ->set('form.billing_address_line_1', '123 Main St')
        ->set('form.billing_city', 'New York')
        ->set('form.billing_country', 'US')
        ->set('form.ship_to_different_address', true)
        ->set('form.ship_to_different_address', false)
        ->assertSet('form.shipping_first_name', 'John')
        ->assertSet('form.shipping_last_name', 'Doe')
        ->assertSet('form.shipping_address_line_1', '123 Main St')
        ->assertSet('form.shipping_city', 'New York')
        ->assertSet('form.shipping_country', 'US');
});

test('can apply coupon code', function () {
    // Create cart
    $cart = Cart::factory()->create([
        'session_id' => session()->getId(),
        'subtotal' => 100.00,
        'total' => 100.00,
        'status' => 'active',
    ]);

    Livewire::test(Checkout::class)
        ->set('form.coupon_code', 'SAVE10')
        ->call('applyCoupon')
        ->assertHasNoErrors();

    // Check if coupon was applied (this depends on the CartService implementation)
    $cart->refresh();
    expect($cart->coupon_code)->toBe('SAVE10');
});

test('cannot place order with empty cart', function () {
    // Create empty cart
    Cart::factory()->create([
        'session_id' => session()->getId(),
        'subtotal' => 0.00,
        'total' => 0.00,
        'status' => 'active',
    ]);

    Livewire::test(Checkout::class)
        ->set('form.billing_first_name', 'John')
        ->set('form.billing_last_name', 'Doe')
        ->set('form.billing_email', 'john@example.com')
        ->set('form.billing_address_line_1', '123 Main St')
        ->set('form.billing_city', 'New York')
        ->set('form.billing_country', 'US')
        ->set('form.payment_method', 'cash_on_delivery')
        ->call('placeOrder')
        ->assertSet('processing', false);

    // Assert no order was created
    $this->assertDatabaseMissing('orders', [
        'status' => 'processing',
    ]);
});

test('checkout validates shipping address when different from billing', function () {
    Livewire::test(Checkout::class)
        ->set('form.ship_to_different_address', true)
        ->set('form.billing_first_name', 'John')
        ->set('form.billing_last_name', 'Doe')
        ->set('form.billing_email', 'john@example.com')
        ->set('form.billing_address_line_1', '123 Main St')
        ->set('form.billing_city', 'New York')
        ->set('form.billing_country', 'US')
        ->set('form.payment_method', 'cash_on_delivery')
        ->call('placeOrder')
        ->assertHasErrors([
            'form.shipping_first_name',
            'form.shipping_last_name',
            'form.shipping_address_line_1',
            'form.shipping_city',
        ]);
});

test('can visit order confirmation page', function () {
    $order = Order::factory()->create([
        'number' => 'ORD-20240101-0001',
        'status' => 'pending',
        'payment_status' => 'unpaid',
        'total' => 100.00,
    ]);

    $response = $this->get(route('order.confirmation', $order->id));

    $response->assertSuccessful();
    $response->assertSee($order->number);
    $response->assertSee('Thank you for your order!');
});

test('guest can create account during checkout', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $user->id, 'price' => 100]);
    $cart = Cart::factory()->create(['session_id' => 'test-session']);
    CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 100,
        'total_price' => 100,
    ]);

    $checkoutData = [
        'billing' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'address_line_1' => '123 Main St',
            'city' => 'New York',
            'country' => 'US',
        ],
        'ship_to_different_address' => false,
        'payment_method' => 'cash_on_delivery',
        'create_account' => true,
        'account_password' => 'password123',
        'save_billing_address' => true,
        'save_shipping_address' => true,
    ];

    $order = $this->orderService->createFromCart($cart, $checkoutData);

    // Verify user was created
    $createdUser = User::where('email', 'john.doe@example.com')->first();
    expect($createdUser)->not->toBeNull();
    expect($createdUser->name)->toBe('John Doe');
    expect($createdUser->role)->toBe('customer');

    // Verify customer was created and linked to user
    expect($order->customer)->not->toBeNull();
    expect($order->customer->user_id)->toBe($createdUser->id);

    // Verify addresses were saved
    expect($order->billingAddress)->not->toBeNull();
    expect($order->shippingAddress)->not->toBeNull();

    // Verify order has correct data
    expect($order->user_id)->toBe($createdUser->id);
    expect($order->meta['guest_account_created'])->toBeTrue();
});

test('default addresses are pre-filled when customer has saved addresses', function () {
    // Create customer with default addresses
    $customer = Customer::factory()->create(['user_id' => $this->user->id]);

    $billingAddress = Address::factory()->create([
        'addressable_type' => Customer::class,
        'addressable_id' => $customer->id,
        'type' => 'billing',
        'is_default' => true,
        'name' => 'John Doe',
        'line1' => '123 Billing St',
        'city' => 'Billing City',
        'country' => 'US',
    ]);

    $shippingAddress = Address::factory()->create([
        'addressable_type' => Customer::class,
        'addressable_id' => $customer->id,
        'type' => 'shipping',
        'is_default' => true,
        'name' => 'John Doe',
        'line1' => '456 Shipping Ave',
        'city' => 'Shipping City',
        'country' => 'US',
    ]);

    $customer->update([
        'default_billing_address_id' => $billingAddress->id,
        'default_shipping_address_id' => $shippingAddress->id,
    ]);

    // Test form pre-filling by simulating checkout component
    $checkout = new Checkout;
    $checkout->form = new CheckoutForm($checkout, 'form');

    auth()->login($this->user);
    $checkout->form->fillWithUserData();

    // Verify billing address is pre-filled
    expect($checkout->form->billing_address_line_1)->toBe('123 Billing St');
    expect($checkout->form->billing_city)->toBe('Billing City');

    // Verify shipping address is pre-filled and different address flag is set
    expect($checkout->form->shipping_address_line_1)->toBe('456 Shipping Ave');
    expect($checkout->form->shipping_city)->toBe('Shipping City');
    expect($checkout->form->ship_to_different_address)->toBeTrue();
});

test('addresses are saved as default when requested', function () {
    $product = Product::factory()->create(['user_id' => $this->user->id, 'price' => 100]);
    $cart = Cart::factory()->create(['user_id' => $this->user->id]);
    CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 100,
        'total_price' => 100,
    ]);

    $checkoutData = [
        'billing' => [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => $this->user->email,
            'phone' => '+1234567890',
            'address_line_1' => '789 New St',
            'city' => 'New City',
            'country' => 'US',
        ],
        'shipping' => [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'address_line_1' => '321 Different St',
            'city' => 'Different City',
            'country' => 'US',
        ],
        'ship_to_different_address' => true,
        'payment_method' => 'cash_on_delivery',
        'save_billing_address' => true,
        'save_shipping_address' => true,
    ];

    auth()->login($this->user);
    $order = $this->orderService->createFromCart($cart, $checkoutData);

    // Verify customer has default addresses set
    $customer = $order->customer;
    expect($customer->default_billing_address_id)->toBe($order->billing_address_id);
    expect($customer->default_shipping_address_id)->toBe($order->shipping_address_id);

    // Verify addresses are marked as default
    expect($order->billingAddress->is_default)->toBeTrue();
    expect($order->shippingAddress->is_default)->toBeTrue();
});

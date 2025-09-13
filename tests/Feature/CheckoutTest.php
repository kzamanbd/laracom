<?php

use App\Livewire\Storefront\Checkout;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Livewire\Livewire;

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

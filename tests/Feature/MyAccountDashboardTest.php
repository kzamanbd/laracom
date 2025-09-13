<?php

use App\Livewire\Storefront\MyAccount\Dashboard;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Livewire\Livewire;

test('authenticated user without customer shows user name', function () {
    $user = User::factory()->create(['name' => 'John Doe']);

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertSee('Hello John Doe!')
        ->assertSee('No Orders Yet');
});

test('authenticated user with customer shows customer full name', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    $customer = Customer::factory()->create([
        'user_id' => $user->id,
        'first_name' => 'Jane',
        'last_name' => 'Smith',
    ]);

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertSee('Hello Jane Smith!')
        ->assertSee('No Orders Yet');
});

test('user can see their orders in dashboard', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create(['user_id' => $user->id]);

    // Create some orders for the user
    $order1 = Order::factory()->create([
        'user_id' => $user->id,
        'customer_id' => $customer->id,
        'number' => 'ORD-12345',
        'status' => 'completed',
        'payment_status' => 'paid',
        'total' => 125.50,
    ]);

    $order2 = Order::factory()->create([
        'user_id' => $user->id,
        'customer_id' => $customer->id,
        'number' => 'ORD-67890',
        'status' => 'processing',
        'payment_status' => 'paid',
        'total' => 89.99,
    ]);

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertSee('Recent Orders')
        ->assertSee('#ORD-12345')
        ->assertSee('#ORD-67890')
        ->assertSee('$125.50')
        ->assertSee('$89.99')
        ->assertSee('Completed')
        ->assertSee('Processing');
});

test('orders tab shows all user orders with details', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create(['user_id' => $user->id]);

    // Create orders with different statuses
    Order::factory()->create([
        'user_id' => $user->id,
        'customer_id' => $customer->id,
        'number' => 'ORD-11111',
        'status' => 'cancelled',
        'payment_status' => 'refunded',
        'total' => 250.00,
    ]);

    Order::factory()->create([
        'user_id' => $user->id,
        'customer_id' => $customer->id,
        'number' => 'ORD-22222',
        'status' => 'paid',
        'payment_status' => 'paid',
        'total' => 199.99,
    ]);

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->call('setTab', 'orders')
        ->assertSee('#ORD-11111')
        ->assertSee('#ORD-22222')
        ->assertSee('Cancelled')
        ->assertSee('Paid')
        ->assertSee('Refunded')
        ->assertSee('$250.00')
        ->assertSee('$199.99');
});

test('users only see their own orders', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $customer1 = Customer::factory()->create(['user_id' => $user1->id]);
    $customer2 = Customer::factory()->create(['user_id' => $user2->id]);

    // Create order for user1
    Order::factory()->create([
        'user_id' => $user1->id,
        'customer_id' => $customer1->id,
        'number' => 'ORD-USER1',
        'total' => 100.00,
    ]);

    // Create order for user2
    Order::factory()->create([
        'user_id' => $user2->id,
        'customer_id' => $customer2->id,
        'number' => 'ORD-USER2',
        'total' => 200.00,
    ]);

    // User 1 should only see their orders
    Livewire::actingAs($user1)
        ->test(Dashboard::class)
        ->assertSee('#ORD-USER1')
        ->assertDontSee('#ORD-USER2');

    // User 2 should only see their orders
    Livewire::actingAs($user2)
        ->test(Dashboard::class)
        ->assertSee('#ORD-USER2')
        ->assertDontSee('#ORD-USER1');
});

test('recent orders are limited to 5 items', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create(['user_id' => $user->id]);

    // Create 10 orders
    for ($i = 1; $i <= 10; $i++) {
        Order::factory()->create([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'number' => "ORD-{$i}",
            'total' => 100.00,
        ]);
    }

    $component = Livewire::actingAs($user)->test(Dashboard::class);

    // Should only show 5 recent orders in the recent orders section
    expect($component->instance()->recentOrders->count())->toBe(5);

    // But all orders should be available in allOrders
    expect($component->instance()->orders->count())->toBe(10);
});

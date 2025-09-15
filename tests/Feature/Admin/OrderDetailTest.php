<?php

use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('admin can view order detail page', function () {
    /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
    $admin = User::factory()->create(['role' => 'admin']);

    $order = Order::factory()
        ->has(OrderItem::factory()->count(2), 'items')
        ->create();

    actingAs($admin);

    get(route('admin.orders.show', $order))
        ->assertSuccessful()
        ->assertSee($order->number);
});

test('order detail shows previous and next navigation when applicable', function () {
    /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
    $admin = User::factory()->create(['role' => 'admin']);

    // Create three orders in order
    $first = Order::factory()->create();
    $middle = Order::factory()->create();
    $last = Order::factory()->create();

    // Add at least one item so the page renders items section
    OrderItem::factory()->for($middle, 'order')->create();

    actingAs($admin);

    // Middle should have both prev and next
    get(route('admin.orders.show', $middle))
        ->assertSuccessful()
        ->assertSee('Order #'.$middle->number)
        ->assertSee(route('admin.orders.show', $first))
        ->assertSee(route('admin.orders.show', $last));

    // First should have only next
    get(route('admin.orders.show', $first))
        ->assertSuccessful()
        ->assertDontSee(route('admin.orders.show', $first)) // previous shouldn't link to itself
        ->assertSee(route('admin.orders.show', $middle));

    // Last should have only previous
    get(route('admin.orders.show', $last))
        ->assertSuccessful()
        ->assertSee(route('admin.orders.show', $middle));
});

<?php

use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\User;
use Livewire\Livewire;

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

test('order detail shows prev/next controls and navigates when applicable', function () {
    /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
    $admin = User::factory()->create(['role' => 'admin']);

    // Create three orders in sequence
    $first = Order::factory()->create();
    $middle = Order::factory()->create();
    $last = Order::factory()->create();

    // Ensure items exist so the page renders items section
    OrderItem::factory()->for($middle, 'order')->create();

    actingAs($admin);

    // Page renders Prev/Next buttons (Livewire actions), not anchor links
    get(route('admin.orders.show', $middle))
        ->assertSuccessful()
        ->assertSee('Order #'.$middle->number)
        ->assertSee('Prev')
        ->assertSee('Next');

    // Using Livewire, middle should redirect to first on Prev and to last on Next
    Livewire::test(\App\Livewire\Admin\Orders\OrderDetail::class, ['order' => $middle])
        ->call('goToPrevious')
        ->assertRedirect(route('admin.orders.show', $first));

    Livewire::test(\App\Livewire\Admin\Orders\OrderDetail::class, ['order' => $middle])
        ->call('goToNext')
        ->assertRedirect(route('admin.orders.show', $last));

    // First/Last pages still show controls; navigation only applies when available
    get(route('admin.orders.show', $first))
        ->assertSuccessful()
        ->assertSee('Prev')
        ->assertSee('Next');

    get(route('admin.orders.show', $last))
        ->assertSuccessful()
        ->assertSee('Prev')
        ->assertSee('Next');
});

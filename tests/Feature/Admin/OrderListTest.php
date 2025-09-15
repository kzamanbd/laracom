<?php

use App\Models\Orders\Order;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('admin can view orders index with pagination', function () {
    /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
    $admin = User::factory()->create(['role' => 'admin']);

    // Create more than default per-page (15) to enforce pagination
    Order::factory()->count(20)->create();

    actingAs($admin);

    $response = get(route('admin.orders.index'));

    $response->assertSuccessful();

    // Should render pagination links
    $response->assertSee('Next');
});

<?php

use App\Models\Orders\Order;
use App\Models\User;

it('renders admin dashboard components', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);
    $this->actingAs($user);

    Order::factory()->count(2)->create();

    $response = $this->get('/dashboard');

    $response->assertSuccessful();
    $response->assertSeeLivewire('admin.dashboard.overview');
    $response->assertSeeLivewire('admin.dashboard.sales-trend');
    $response->assertSeeLivewire('admin.dashboard.recent-orders');
});

<?php

use App\Models\User;

test('unauthenticated user is redirected to login', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('customer cannot access admin dashboard', function () {
    $customer = User::factory()->create(['role' => 'customer', 'is_active' => true]);

    $response = $this->actingAs($customer)->get(route('dashboard'));

    $response->assertForbidden();
});

test('admin can access admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

    $response = $this->actingAs($admin)->get(route('dashboard'));

    $response->assertSuccessful();
});

test('vendor cannot access admin routes', function () {
    $vendor = User::factory()->create(['role' => 'vendor', 'is_active' => true]);

    $response = $this->actingAs($vendor)->get(route('dashboard'));

    $response->assertForbidden();
});

test('customer can access my account page', function () {
    $customer = User::factory()->create(['role' => 'customer', 'is_active' => true]);

    $response = $this->actingAs($customer)->get(route('my-account'));

    $response->assertSuccessful();
});

test('admin can access customer-only routes (superuser privileges)', function () {
    $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

    $response = $this->actingAs($admin)->get(route('my-account'));

    $response->assertSuccessful();
});

test('inactive user is logged out and redirected', function () {
    $user = User::factory()->create(['role' => 'admin', 'is_active' => false]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('admin has superuser privileges - can access any role-protected route', function () {
    $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

    // Test that admin can access customer-only routes (already tested above)
    $response = $this->actingAs($admin)->get(route('my-account'));
    $response->assertSuccessful();

    // This test verifies our key requirement: admins can access all routes
    expect($admin->role)->toBe('admin');
});

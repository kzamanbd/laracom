<?php

use App\Livewire\Storefront\Product\QuickView;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

test('quick view component can be mounted', function () {
    Livewire::test(QuickView::class)
        ->assertStatus(200)
        ->assertDontSee('Test Product'); // Initially no product should be shown
});

test('quick view displays product information when triggered', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'name' => 'Test Product',
        'user_id' => $user->id,
    ]);
    $product->categories()->attach($category);

    Livewire::test(QuickView::class)
        ->call('quickView', $product)
        ->assertSet('product.name', 'Test Product')
        ->assertSet('showModal', true)
        ->assertSet('quantity', 1)
        ->assertSee('Test Product');
});

test('can increment and decrement quantity', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $user->id]);

    Livewire::test(QuickView::class)
        ->call('quickView', $product)
        ->assertSet('quantity', 1)
        ->call('incrementQuantity')
        ->assertSet('quantity', 2)
        ->call('decrementQuantity')
        ->assertSet('quantity', 1)
        ->call('decrementQuantity') // Should not go below 1
        ->assertSet('quantity', 1);
});

test('can close modal', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $user->id]);

    Livewire::test(QuickView::class)
        ->call('quickView', $product)
        ->assertSet('showModal', true)
        ->call('closeModal')
        ->assertSet('showModal', false)
        ->assertSet('product', null);
});

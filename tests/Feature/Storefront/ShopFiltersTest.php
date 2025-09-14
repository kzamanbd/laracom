<?php

declare(strict_types=1);

use App\Livewire\Storefront\Catalog\Filters;
use App\Livewire\Storefront\Catalog\ProductCatalog;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('shop filters component can be rendered', function () {
    Livewire::test(Filters::class)
        ->assertStatus(200);
});

test('shop list view component can be rendered', function () {
    Livewire::test(ProductCatalog::class)
        ->assertStatus(200);
});

test('can filter products by price range', function () {
    $user = User::factory()->create();

    Product::factory()->create([
        'user_id' => $user->id,
        'name' => 'Cheap Item',
        'price' => 10,
        'status' => 'active',
    ]);

    Product::factory()->create([
        'user_id' => $user->id,
        'name' => 'Expensive Item',
        'price' => 1000,
        'status' => 'active',
    ]);

    $listView = Livewire::test(ProductCatalog::class);

    // Filter by price range 0-50
    $listView->dispatch('filtersChanged', [
        'categories' => [],
        'minPrice' => 0,
        'maxPrice' => 50,
        'colors' => [],
        'conditions' => [],
    ]);

    expect($listView->get('products')->count())->toBe(1);
    expect($listView->get('products')->first()->name)->toBe('Cheap Item');
});

test('can filter products by color', function () {
    $user = User::factory()->create();

    Product::factory()->create([
        'user_id' => $user->id,
        'name' => 'Red Shirt',
        'price' => 25,
        'status' => 'active',
        'attributes' => ['color' => 'red'],
    ]);

    Product::factory()->create([
        'user_id' => $user->id,
        'name' => 'Blue Shirt',
        'price' => 25,
        'status' => 'active',
        'attributes' => ['color' => 'blue'],
    ]);

    $listView = Livewire::test(ProductCatalog::class);

    // Filter by red color
    $listView->dispatch('filtersChanged', [
        'categories' => [],
        'minPrice' => null,
        'maxPrice' => null,
        'colors' => ['red'],
        'conditions' => [],
    ]);

    expect($listView->get('products')->count())->toBe(1);
    expect($listView->get('products')->first()->name)->toBe('Red Shirt');
});

test('filters component shows available categories', function () {
    // Create test data
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'name' => 'Test Category',
        'is_active' => true,
    ]);

    $product = Product::factory()->create([
        'user_id' => $user->id,
        'status' => 'active',
    ]);

    // Use sync instead of attach to avoid duplicate key issues
    $product->categories()->sync([$category->id]);

    // Test the component
    $filters = Livewire::test(Filters::class);

    // Get the categories and verify
    $categories = $filters->get('categories');
    expect($categories)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);

    $testCategory = $categories->where('name', 'Test Category')->first();
    expect($testCategory)->not->toBeNull();
    expect($testCategory->products_count)->toBe(1);
});

test('can reset filters', function () {
    $filters = Livewire::test(Filters::class)
        ->set('selectedCategories', [1, 2])
        ->set('selectedColors', ['red', 'blue'])
        ->set('selectedConditions', ['new'])
        ->call('resetFilters');

    expect($filters->get('selectedCategories'))->toBe([]);
    expect($filters->get('selectedColors'))->toBe([]);
    expect($filters->get('selectedConditions'))->toBe([]);
});

test('filters component shows new products', function () {
    $user = User::factory()->create();

    Product::factory(5)->create([
        'user_id' => $user->id,
        'status' => 'active',
    ]);

    $filters = Livewire::test(Filters::class);

    expect($filters->get('newProducts')->count())->toBe(3);
});

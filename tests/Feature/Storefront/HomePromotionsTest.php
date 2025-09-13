<?php

use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page displays current promotions in slider', function () {
    // Create some current promotions
    $activePromotion = Promotion::factory()->current()->create([
        'title' => 'Fresh Vegetables',
        'subtitle' => 'Save up to 50% off',
        'button_text' => 'Shop Now',
        'link_url' => '/shop?category=vegetables',
        'position' => 1,
    ]);

    $inactivePromotion = Promotion::factory()->inactive()->create([
        'title' => 'Inactive Promotion',
        'position' => 2,
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertSee($activePromotion->title)
        ->assertSee($activePromotion->subtitle)
        ->assertSee($activePromotion->button_text)
        ->assertDontSee($inactivePromotion->title);
});

test('home page promotions are ordered by position', function () {
    $promotion1 = Promotion::factory()->current()->create([
        'title' => 'Second Promotion',
        'position' => 2,
    ]);

    $promotion2 = Promotion::factory()->current()->create([
        'title' => 'First Promotion',
        'position' => 1,
    ]);

    $response = $this->get(route('home'));

    $content = $response->getContent();
    $pos1 = strpos($content, 'First Promotion');
    $pos2 = strpos($content, 'Second Promotion');

    expect($pos1)->toBeLessThan($pos2);
});

test('home page only shows promotions within date range', function () {
    $currentPromotion = Promotion::factory()->current()->create([
        'title' => 'Current Promotion',
    ]);

    $expiredPromotion = Promotion::factory()->expired()->create([
        'title' => 'Expired Promotion',
    ]);

    $upcomingPromotion = Promotion::factory()->upcoming()->create([
        'title' => 'Upcoming Promotion',
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertSee($currentPromotion->title)
        ->assertDontSee($expiredPromotion->title)
        ->assertDontSee($upcomingPromotion->title);
});

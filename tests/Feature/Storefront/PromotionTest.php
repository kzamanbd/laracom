<?php

declare(strict_types=1);

use App\Models\Marketing\Promotion;

test('promotion factory creates valid promotion', function () {
    $promotion = Promotion::factory()->create();

    expect($promotion)
        ->toBeInstanceOf(Promotion::class)
        ->and($promotion->title)->not->toBeEmpty()
        ->and($promotion->position)->toBeInt()
        ->and($promotion->is_active)->toBeBool();
});

test('promotion factory creates active promotion', function () {
    $promotion = Promotion::factory()->active()->create();

    expect($promotion->is_active)->toBeTrue();
});

test('promotion factory creates current promotion', function () {
    $promotion = Promotion::factory()->current()->create();

    expect($promotion->isCurrentlyActive())->toBeTrue();
});

test('promotion scope returns only active promotions', function () {
    Promotion::factory()->active()->count(3)->create();
    Promotion::factory()->inactive()->count(2)->create();

    $activePromotions = Promotion::active()->get();

    expect($activePromotions)->toHaveCount(3);

    foreach ($activePromotions as $promotion) {
        expect($promotion->is_active)->toBeTrue();
    }
});

test('promotion scope returns only current promotions', function () {
    Promotion::factory()->current()->count(2)->create();
    Promotion::factory()->expired()->count(1)->create();
    Promotion::factory()->upcoming()->count(1)->create();

    $currentPromotions = Promotion::current()->get();

    expect($currentPromotions)->toHaveCount(2);

    foreach ($currentPromotions as $promotion) {
        expect($promotion->isCurrentlyActive())->toBeTrue();
    }
});

test('promotion is currently active method works correctly', function () {
    $activePromotion = Promotion::factory()->current()->create();
    $expiredPromotion = Promotion::factory()->expired()->create();
    $upcomingPromotion = Promotion::factory()->upcoming()->create();

    expect($activePromotion->isCurrentlyActive())->toBeTrue()
        ->and($expiredPromotion->isCurrentlyActive())->toBeFalse()
        ->and($upcomingPromotion->isCurrentlyActive())->toBeFalse();
});

test('promotion ordered scope works correctly', function () {
    Promotion::factory()->create(['position' => 3]);
    Promotion::factory()->create(['position' => 1]);
    Promotion::factory()->create(['position' => 2]);

    $orderedPromotions = Promotion::ordered()->get();

    expect($orderedPromotions->first()->position)->toBe(1)
        ->and($orderedPromotions->get(1)->position)->toBe(2)
        ->and($orderedPromotions->last()->position)->toBe(3);
});

test('promotion current with media factory state works', function () {
    $promotion = Promotion::factory()
        ->current()
        ->withMedia()
        ->create();

    expect($promotion->isCurrentlyActive())->toBeTrue()
        ->and($promotion->image())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphOne::class);
});

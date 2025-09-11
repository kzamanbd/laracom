<?php

declare(strict_types=1);

use App\Livewire\Storefront\Product\QuickView;
use Livewire\Livewire;

test('quick view modal shows loading state initially', function () {
    $component = Livewire::test(QuickView::class);

    // Initially, modal should be closed
    expect($component->get('showModal'))->toBeFalse();
    expect($component->get('isLoading'))->toBeFalse();
    expect($component->get('product'))->toBeNull();
});

test('quick view modal can be closed', function () {
    $component = Livewire::test(QuickView::class);

    // Set up modal state
    $component->set('showModal', true);
    $component->set('isLoading', true);

    // Close modal
    $component->call('closeModal');

    // Everything should be reset
    expect($component->get('showModal'))->toBeFalse();
    expect($component->get('isLoading'))->toBeFalse();
    expect($component->get('product'))->toBeNull();
    expect($component->get('quantity'))->toBe(1);
});

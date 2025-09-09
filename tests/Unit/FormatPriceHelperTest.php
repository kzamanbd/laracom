<?php

test('formatPrice function exists and is callable', function () {
    expect(function_exists('formatPrice'))->toBeTrue();
});

test('formatPrice returns a string', function () {
    expect(formatPrice(100))->toBeString();
});

test('formatPrice handles numeric amounts correctly', function () {
    $result = formatPrice(100);
    expect($result)->toContain('100');
});

test('formatPrice handles null amount', function () {
    $result = formatPrice(null);
    expect($result)->toContain('0');
});

test('formatPrice works with different currencies', function () {
    $usdResult = formatPrice(100, 2, 'USD');
    $eurResult = formatPrice(100, 2, 'EUR');
    $gbpResult = formatPrice(100, 2, 'GBP');

    expect($usdResult)->toBeString();
    expect($eurResult)->toBeString();
    expect($gbpResult)->toBeString();
});

test('formatPrice handles large numbers', function () {
    $result = formatPrice(1234567.89);
    expect($result)->toBeString();
    expect($result)->toContain('1');
});

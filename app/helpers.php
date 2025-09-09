<?php

use Illuminate\Support\Number;

function formatPrice($amount, int $precision = 2, string $currency = 'USD'): string
{
    return Number::currency($amount ?? 0, $currency, precision: $precision);
}

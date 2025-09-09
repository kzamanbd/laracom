<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $this->faker->randomFloat(2, 5, 200);
        $totalPrice = $quantity * $unitPrice;

        return [
            'cart_id' => \App\Models\Cart::factory(),
            'product_id' => \App\Models\Product::factory(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'currency' => 'USD',
            'product_name' => $this->faker->words(3, true),
            'product_sku' => $this->faker->unique()->lexify('SKU-????'),
            'product_attributes' => null,
            'tax_id' => null,
            'tax_rate' => 0,
            'tax_amount' => 0,
            'meta' => null,
            'notes' => null,
        ];
    }

    /**
     * Create an item with specific attributes
     */
    public function withAttributes(array $attributes): static
    {
        return $this->state([
            'product_attributes' => $attributes,
        ]);
    }

    /**
     * Create an item with tax
     */
    public function withTax(float $rate = 8.5): static
    {
        return $this->state(function (array $attributes) use ($rate) {
            $taxAmount = ($attributes['total_price'] * $rate) / 100;

            return [
                'tax_rate' => $rate,
                'tax_amount' => $taxAmount,
            ];
        });
    }
}

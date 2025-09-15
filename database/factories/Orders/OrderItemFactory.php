<?php

namespace Database\Factories\Orders;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\OrderItem>
 */
class OrderItemFactory extends Factory
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
        $discount = 0.0;
        $tax = 0.0;

        return [
            'order_id' => null,   // set by relation
            'product_id' => null, // set by relation or optional
            'sku' => $this->faker->bothify('SKU-########'),
            'name' => $this->faker->words(3, true),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_total' => $discount,
            'tax_total' => $tax,
            'total' => ($unitPrice * $quantity) - $discount + $tax,
            'meta' => null,
        ];
    }
}

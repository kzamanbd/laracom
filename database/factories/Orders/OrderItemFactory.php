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
        return [
            'order_id' => null,   // set in seeder
            'product_id' => null, // set in seeder
            'sku' => null,
            'name' => null,
            'quantity' => $this->faker->numberBetween(1, 5),
            'unit_price' => 0,
            'discount_total' => 0,
            'tax_total' => 0,
            'total' => 0,
            'meta' => null,
        ];
    }
}

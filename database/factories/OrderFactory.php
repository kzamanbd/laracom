<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => 'ORD-' . $this->faker->unique()->numerify('########'),
            'customer_id' => null, // set in seeder
            'user_id' => null,     // set in seeder (if customer has user)
            'status' => $this->faker->randomElement(['pending','paid','processing','completed','cancelled','refunded']),
            'currency' => 'USD',
            'subtotal' => 0,
            'discount_total' => 0,
            'tax_total' => 0,
            'shipping_total' => 0,
            'total' => 0,
            'payment_status' => $this->faker->randomElement(['unpaid','paid','partially_refunded','refunded']),
            'billing_address_id' => null,
            'shipping_address_id' => null,
            'customer_note' => $this->faker->optional()->sentence(12),
            'meta' => null,
            'placed_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
        ];
    }
}

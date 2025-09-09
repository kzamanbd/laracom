<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session_id' => $this->faker->uuid(),
            'currency' => 'USD',
            'subtotal' => $this->faker->randomFloat(2, 10, 500),
            'discount_total' => 0,
            'tax_total' => 0,
            'shipping_total' => 0,
            'total' => fn (array $attributes) => $attributes['subtotal'],
            'status' => 'active',
            'last_activity_at' => now(),
            'expires_at' => now()->addDays(30),
            'meta' => null,
            'coupon_code' => null,
            'coupon_discount' => 0,
        ];
    }

    /**
     * Create a cart for a specific user
     */
    public function forUser($user): static
    {
        return $this->state([
            'user_id' => $user->id,
            'session_id' => null,
        ]);
    }

    /**
     * Create an abandoned cart
     */
    public function abandoned(): static
    {
        return $this->state([
            'status' => 'abandoned',
            'last_activity_at' => now()->subDays(7),
        ]);
    }

    /**
     * Create an expired cart
     */
    public function expired(): static
    {
        return $this->state([
            'status' => 'expired',
            'expires_at' => now()->subDays(1),
        ]);
    }
}

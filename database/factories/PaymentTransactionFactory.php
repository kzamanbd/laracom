<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentTransaction>
 */
class PaymentTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => null,
            'provider' => $this->faker->randomElement(['stripe', 'braintree', 'sslcommerz', 'paypal']),
            'reference' => strtoupper($this->faker->bothify('TXN########')),
            'amount' => 0,
            'currency' => 'USD',
            'status' => $this->faker->randomElement(['initiated', 'succeeded', 'failed', 'refunded', 'partially_refunded']),
            'payload' => null,
            'processed_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
        ];
    }
}

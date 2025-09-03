<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tax>
 */
class TaxFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'VAT ' . $this->faker->numberBetween(5, 20) . '%',
            'rate' => $this->faker->randomElement([0.05,0.07,0.10,0.12,0.15,0.18,0.20]),
            'inclusive' => false,
            'country' => $this->faker->randomElement(['US','CA','GB','AU','DE','BD']),
            'state' => null,
            'postal_code' => null,
            'priority' => 1,
            'compound' => false,
            'enabled' => true,
            'meta' => null,
        ];
    }
}

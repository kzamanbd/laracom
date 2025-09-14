<?php

namespace Database\Factories\Core;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Core\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'addressable_type' => null, // set in seeder
            'addressable_id' => null, // set in seeder
            'type' => $this->faker->randomElement(['billing', 'shipping']),
            'name' => $this->faker->name(),
            'company' => $this->faker->optional()->company(),
            'phone' => $this->faker->optional()->e164PhoneNumber(),
            'line1' => $this->faker->streetAddress(),
            'line2' => $this->faker->optional()->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->optional()->state(),
            'postal_code' => $this->faker->optional()->postcode(),
            'country' => $this->faker->randomElement(['US', 'CA', 'GB', 'AU', 'DE', 'BD']),
            'is_default' => false,
            'meta' => null,
        ];
    }
}

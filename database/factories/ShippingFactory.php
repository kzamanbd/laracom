<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipping>
 */
class ShippingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => null, // set in seeder
            'carrier' => $this->faker->randomElement(['DHL', 'FedEx', 'UPS', 'USPS', 'Aramex']),
            'service' => $this->faker->randomElement(['Ground', 'Express', 'Priority', 'Economy']),
            'tracking_number' => strtoupper($this->faker->bothify('???########')),
            'status' => $this->faker->randomElement(['pending', 'label_printed', 'shipped', 'in_transit', 'delivered', 'returned']),
            'cost' => $this->faker->randomFloat(2, 5, 50),
            'shipped_at' => $this->faker->optional(0.7)->dateTimeBetween('-30 days', 'now'),
            'delivered_at' => null, // will set if status delivered
            'meta' => null,
        ];
    }
}

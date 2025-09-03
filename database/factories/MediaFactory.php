<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_type' => null,
            'model_id'   => null,
            'disk' => 'public',
            'alt' => $this->faker->sentence(3),
            'caption' => $this->faker->optional()->sentence(6),
            'order_column' => $this->faker->numberBetween(0, 5),
        ];
    }
}

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
            'model_id' => null,
            'title' => $this->faker->optional()->sentence(6),
            'alt' => $this->faker->sentence(3),
            'disk' => 'public',
        ];
    }
}

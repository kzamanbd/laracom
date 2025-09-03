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
        $file = $this->faker->randomElement([
            'sample-1.jpg','sample-2.jpg','sample-3.jpg','sample-4.jpg','sample-5.jpg'
        ]);

        return [
            'model_type' => null,
            'model_id'   => null,
            'collection' => 'product_images',
            'disk' => 'public',
            'directory' => 'products',
            'filename' => $file,
            'extension' => 'jpg',
            'mime_type' => 'image/jpeg',
            'size_bytes' => $this->faker->numberBetween(80_000, 1_200_000),
            'path' => 'products/' . $file,
            'alt' => $this->faker->sentence(3),
            'caption' => $this->faker->optional()->sentence(6),
            'order_column' => $this->faker->numberBetween(0, 5),
            'variants' => null,
            'meta' => null,
        ];
    }
}

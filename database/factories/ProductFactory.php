<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'user_id' => null, // set in seeder
            'name' => Str::title($name),
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(10000, 99999),
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-#####')),
            'type' => 'simple',
            'short_description' => $this->faker->sentence(10),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'sale_price' => null,
            'currency' => 'USD',
            'quantity' => $this->faker->numberBetween(0, 500),
            'requires_shipping' => true,
            'status' => 'active',
            'weight_kg' => $this->faker->randomFloat(3, 0.05, 10),
            'length_cm' => $this->faker->randomFloat(2, 5, 100),
            'width_cm' => $this->faker->randomFloat(2, 5, 100),
            'height_cm' => $this->faker->randomFloat(2, 1, 80),
            'tax_id' => null, // set in seeder
            'attributes' => null,
            'meta' => null,
            'published_at' => now(),
        ];
    }

    /**
     * After a product is created, attach 1–3 random categories if any exist.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            // Pick from active categories only; fall back if none exist yet
            $categoryIds = Category::query()
                ->where('is_active', true)
                ->inRandomOrder()
                ->limit(fake()->numberBetween(1, 3))
                ->pluck('id');

            if ($categoryIds->isNotEmpty()) {
                $product->categories()->syncWithoutDetaching($categoryIds->all());
            }
        });
    }
}

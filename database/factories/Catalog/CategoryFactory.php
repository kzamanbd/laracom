<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'parent_id' => null, // set manually for subcategories
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'description' => $this->faker->sentence(10),
            'is_active' => $this->faker->boolean(90),
            'order_column' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * State for subcategories (assigns random parent)
     */
    public function child(Category $parent): self
    {
        return $this->state(fn () => [
            'parent_id' => $parent->id,
        ]);
    }
}

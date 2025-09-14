<?php

namespace Database\Factories\Marketing;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marketing\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');

        return [
            'title' => $this->faker->randomElement([
                'Fresh Vegetables',
                'Organic Fruits Daily',
                'Summer Sale Special',
                'Weekend Big Sale',
                'Best Deals Today',
                'Free Shipping Offer',
            ]),
            'subtitle' => $this->faker->randomElement([
                'Save up to 50% off',
                '100% Fresh & Natural',
                'Free delivery over $30',
                'Limited time offer',
                'Shop now and save',
                'Fresh from farm to table',
            ]),
            'link_url' => $this->faker->randomElement([
                '/shop',
                '/categories/vegetables',
                '/categories/fruits',
                '/promotions',
                '/deals',
            ]),
            'button_text' => $this->faker->randomElement([
                'Shop Now',
                'Buy Now',
                'Explore',
                'Get Started',
                'Learn More',
                'View Deals',
            ]),
            'position' => $this->faker->numberBetween(1, 10),
            'start_date' => $startDate,
            'end_date' => $this->faker->dateTimeBetween($startDate, '+2 months'),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Indicate that the promotion is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the promotion is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the promotion is currently running.
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(10),
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the promotion is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(20),
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the promotion is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(30),
            'end_date' => now()->subDays(5),
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the promotion should have media uploaded.
     */
    public function withMedia(): static
    {
        return $this->afterCreating(function ($promotion) {
            DatabaseSeeder::createMedia($promotion, [
                'directory' => 'promotions',
                'pattern' => 'slider-',
                'root' => 'slider',
                'collection' => 'images',
            ]);
        });
    }
}

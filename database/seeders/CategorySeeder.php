<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory()->count(12)->create();
        $categories->each(function (Category $root) {
            Category::factory()
                ->count(fake()->numberBetween(3, 6))
                ->create(['parent_id' => $root->id]);
        });
        Category::query()
            ->whereNotNull('parent_id')
            ->inRandomOrder()
            ->take(20)
            ->get()
            ->each(function (Category $child) {
                Category::factory()
                    ->count(fake()->numberBetween(1, 3))
                    ->create(['parent_id' => $child->id]);
            });
    }
}

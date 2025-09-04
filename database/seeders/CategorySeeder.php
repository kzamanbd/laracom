<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory()->count(50)->create();
        $categories->each(function (Category $c) {
            DatabaseSeeder::createMedia($c, [
                'directory' => 'categories',
                'pattern' => 'category-',
                'collection' => 'category_images',
            ]);
            $subCategories = Category::factory()
                ->count(fake()->numberBetween(10, 15))
                ->create(['parent_id' => $c->id]);

            $subCategories->each(function (Category $c) {
                Category::factory()
                    ->count(fake()->numberBetween(10, 15))
                    ->create(['parent_id' => $c->id]);
            });
        });
    }
}

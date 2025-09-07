<?php

namespace Database\Seeders;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CategorySeeder extends Seeder
{

    public function getRemoteData()
    {
        $localCategories = [
            "Electronics",
            "Smartphones",
            "Laptops",
            "Cameras",
            "Audio & Headphones",
            "Wearable Tech",
            "Home Appliances",
            "Furniture",
            "Kitchenware",
            "Books",
            "Fashion - Men",
            "Fashion - Women",
            "Shoes",
            "Sports & Outdoors",
            "Beauty & Personal Care",
            "Health & Wellness",
            "Toys & Games",
            "Baby Products",
            "Automotive",
            "Jewelry & Watches",
            "Office Supplies",
            "Pet Supplies",
            "Groceries",
            "Musical Instruments",
            "Garden & Outdoor",
            "Lighting & Decor",
            "Tools & Hardware",
            "Travel & Luggage",
            "Gaming",
            "Crafts & Hobbies"
        ];
        try {
            $categories = array_merge(DatabaseSeeder::getData('products/categories', 'categories'), $localCategories);

            return collect($categories)
                ->pluck('name')
                ->unique()
                ->values();
        } catch (Exception $e) {
            return collect($localCategories)
                ->unique()
                ->values();
        }
    }
    public function run(): void
    {
        $categories = $this->getRemoteData();
        // set max progress
        $this->command->getOutput()->progressStart(count($categories));
        foreach ($categories as $categoryName) {
            $category = Category::firstOrCreate([
                'name' => ucwords($categoryName),
                'slug' => Str::slug($categoryName),
            ], [
                'description' => fake()->sentence(),
                'is_active' => true,
            ]);
            DatabaseSeeder::createMedia($category, [
                'directory' => 'categories',
                'pattern' => 'category-',
                'collection' => 'category_images',
            ]);

            $subCategories = Category::factory()
                ->count(fake()->numberBetween(10, 15))
                ->create(['parent_id' => $category->id]);

            $subCategories->each(function (Category $c) {
                Category::factory()
                    ->count(fake()->numberBetween(10, 15))
                    ->create(['parent_id' => $c->id]);
            });
            $this->command->getOutput()->progressAdvance(); // move the bar one step
        }
        $this->command->getOutput()->progressFinish();
    }
}

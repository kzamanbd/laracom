<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Exception;
use Illuminate\Support\Str;
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
            $response = Http::get('https://dummyjson.com/products/categories');
            $categories = array_merge($response->json(), $localCategories);

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
        }
    }
}

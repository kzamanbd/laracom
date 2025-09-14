<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function getLocalCategories($withChildren = true)
    {
        $categories = [
            'Electronics' => [
                'Televisions',
                'Tablets',
                'Drones',
                'Projectors',
                'Printers & Scanners',
            ],
            'Smartphones' => [
                'Android Phones',
                'iPhones',
                'Feature Phones',
                'Smartphone Accessories',
                'Mobile Cases & Covers',
            ],
            'Laptops' => [
                'Gaming Laptops',
                'Business Laptops',
                'Ultrabooks',
                '2-in-1 Laptops',
                'Laptop Accessories',
            ],
            'Cameras' => [
                'DSLR Cameras',
                'Mirrorless Cameras',
                'Action Cameras',
                'Camera Lenses',
                'Tripods & Stabilizers',
            ],
            'Audio & Headphones' => [
                'Bluetooth Speakers',
                'Wireless Headphones',
                'Earbuds',
                'Home Theater Systems',
                'Soundbars',
            ],
            'Wearable Tech' => [
                'Smartwatches',
                'Fitness Bands',
                'AR/VR Headsets',
                'Smart Glasses',
                'Wearable Accessories',
            ],
            'Home Appliances' => [
                'Refrigerators',
                'Washing Machines',
                'Microwaves',
                'Air Conditioners',
                'Vacuum Cleaners',
            ],
            'Furniture' => [
                'Sofas',
                'Beds',
                'Dining Tables',
                'Office Chairs',
                'Wardrobes',
            ],
            'Kitchenware' => [
                'Cookware',
                'Cutlery',
                'Dinner Sets',
                'Bakeware',
                'Food Storage',
            ],
            'Books' => [
                'Fiction',
                'Non-Fiction',
                'Children’s Books',
                'Academic & Textbooks',
                'Comics & Graphic Novels',
            ],
            'Fashion - Men' => [
                'Shirts',
                'T-Shirts',
                'Jeans',
                'Jackets',
                'Suits & Blazers',
            ],
            'Fashion - Women' => [
                'Dresses',
                'Tops',
                'Skirts',
                'Ethnic Wear',
                'Handbags',
            ],
            'Shoes' => [
                'Sneakers',
                'Formal Shoes',
                'Sandals',
                'Boots',
                'Sports Shoes',
            ],
            'Sports & Outdoors' => [
                'Fitness Equipment',
                'Camping Gear',
                'Cycling',
                'Team Sports',
                'Swimming',
            ],
            'Beauty & Personal Care' => [
                'Skincare',
                'Makeup',
                'Haircare',
                'Fragrances',
                'Men’s Grooming',
            ],
            'Health & Wellness' => [
                'Vitamins & Supplements',
                'Medical Devices',
                'Fitness Trackers',
                'Massage Equipment',
                'First Aid',
            ],
            'Toys & Games' => [
                'Action Figures',
                'Board Games',
                'Puzzles',
                'Dolls',
                'Remote-Control Toys',
            ],
            'Baby Products' => [
                'Diapers',
                'Baby Clothing',
                'Feeding Bottles',
                'Strollers',
                'Car Seats',
            ],
            'Automotive' => [
                'Car Accessories',
                'Motorbike Accessories',
                'Car Electronics',
                'Tyres & Wheels',
                'Car Care Products',
            ],
            'Jewelry & Watches' => [
                'Necklaces',
                'Earrings',
                'Bracelets',
                'Wristwatches',
                'Rings',
            ],
            'Office Supplies' => [
                'Stationery',
                'Printers',
                'Office Chairs',
                'Paper Products',
                'Desk Organizers',
            ],
            'Pet Supplies' => [
                'Pet Food',
                'Pet Grooming',
                'Pet Toys',
                'Aquariums',
                'Pet Beds',
            ],
            'Groceries' => [
                'Fruits & Vegetables',
                'Snacks',
                'Beverages',
                'Dairy Products',
                'Bakery',
            ],
            'Musical Instruments' => [
                'Guitars',
                'Keyboards',
                'Drums',
                'Wind Instruments',
                'DJ Equipment',
            ],
            'Garden & Outdoor' => [
                'Plants & Seeds',
                'Gardening Tools',
                'Outdoor Furniture',
                'Grills & BBQ',
                'Watering Equipment',
            ],
            'Lighting & Decor' => [
                'Lamps',
                'Ceiling Lights',
                'Wall Decor',
                'Clocks',
                'Candles',
            ],
            'Tools & Hardware' => [
                'Power Tools',
                'Hand Tools',
                'Tool Storage',
                'Safety Gear',
                'Building Materials',
            ],
            'Travel & Luggage' => [
                'Suitcases',
                'Backpacks',
                'Travel Accessories',
                'Duffel Bags',
                'Travel Pillows',
            ],
            'Gaming' => [
                'Gaming Consoles',
                'Gaming Laptops',
                'Game Titles',
                'Gaming Accessories',
                'VR Gaming',
            ],
            'Crafts & Hobbies' => [
                'Art Supplies',
                'Sewing & Knitting',
                'Model Kits',
                'Scrapbooking',
                'DIY Tools',
            ],
            'Uncategorized' => [],
        ];

        if ($withChildren) {
            return $categories;
        }

        return array_keys($categories);
    }

    public function run(): void
    {
        $categories = $this->getLocalCategories();
        // set max progress
        $this->command->getOutput()->progressStart(count($categories));
        foreach ($categories as $title => $values) {
            $newCategory = Category::firstOrCreate([
                'slug' => Str::slug($title),
            ], [
                'name' => $title,
                'description' => fake()->sentence(),
                'is_active' => true,
            ]);
            DatabaseSeeder::createMedia($newCategory, [
                'directory' => 'categories',
                'pattern' => 'category-',
            ]);

            foreach ($values ?? [] as $child) {
                Category::firstOrCreate([
                    'slug' => Str::slug($child),
                ], [
                    'parent_id' => $newCategory->id,
                    'name' => $child,
                    'description' => fake()->sentence(),
                    'is_active' => true,
                ]);
            }

            $this->command->getOutput()->progressAdvance(); // move the bar one step
        }
        $this->command->getOutput()->progressFinish();
    }
}

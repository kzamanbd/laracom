<?php

namespace Database\Seeders;

use App\Models\Marketing\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentPromotions = [
            [
                'title' => 'Fresh Vegetables',
                'subtitle' => 'Save up to 50% off on fresh organic vegetables',
                'link_url' => '/shop?category=vegetables',
                'button_text' => 'Shop Now',
                'position' => 1,
            ],
            [
                'title' => 'Organic Fruits Daily',
                'subtitle' => '100% Fresh & Natural fruits delivered to your door',
                'link_url' => '/shop?category=fruits',
                'button_text' => 'Explore',
                'position' => 2,
            ],
            [
                'title' => 'Summer Sale Special',
                'subtitle' => 'Free delivery over $30 - Limited time offer',
                'link_url' => '/shop',
                'button_text' => 'Buy Now',
                'position' => 3,
            ],
        ];
        // Create some current active promotions for the homepage slider
        Promotion::factory()->withMedia()->createMany($currentPromotions);

        // Create some upcoming promotions
        Promotion::factory()->withMedia()->upcoming()->count(2)->create();

        // Create some expired promotions
        Promotion::factory()->withMedia()->expired()->count(3)->create();

        // Create some random promotions for variety
        Promotion::factory()->withMedia()->count(5)->create();
    }
}

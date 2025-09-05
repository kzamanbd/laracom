<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Category;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
{
    public function getRemoteProducts()
    {
        $response = Http::get('hhttps://dummyjson.com/products?limit=2000');
        return collect($response->json());
    }
    public function run(): void
    {
        $taxes = Tax::all();
        $vendors = User::where('role', 'vendor')->get();
        $allProducts = new Collection();
        $allCategoryIds = Category::where('is_active', true)->pluck('id');
        foreach ($vendors as $vendor) {
            $count = fake()->numberBetween(10, 30);
            $vendorProducts = Product::factory()
                ->count($count)
                ->create([
                    'user_id' => $vendor->id,
                    'tax_id' => $taxes->random()->id,
                ]);
            $vendorProducts->each(function (Product $p) use ($allCategoryIds) {
                // add product images
                DatabaseSeeder::createMedia($p, [
                    'directory' => 'products',
                    'collection' => 'product_images',
                    'pattern' => 'product-',
                    'total' => fake()->numberBetween(3, 4),
                ]);

                // add feature image
                DatabaseSeeder::createMedia($p, [
                    'directory' => 'products',
                    'collection' => 'product_feature',
                    'pattern' => 'thumbnail-',
                ]);

                $attachIds = $allCategoryIds->shuffle()->take(fake()->numberBetween(1, 3))->all();
                $p->categories()->syncWithoutDetaching($attachIds);
            });
            $allProducts = $allProducts->merge($vendorProducts);
        }
    }
}

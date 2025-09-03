<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Category;
use App\Models\Media;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = User::where('role', 'vendor')->get();

        $taxes = Tax::all();
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
                Media::factory()->count(fake()->numberBetween(1, 3))->create([
                    'model_type' => Product::class,
                    'model_id' => $p->id,
                    'collection' => 'product_images',
                ]);
                $attachIds = $allCategoryIds->shuffle()->take(fake()->numberBetween(1, 3))->all();
                $p->categories()->syncWithoutDetaching($attachIds);
            });
            $allProducts = $allProducts->merge($vendorProducts);
        }
    }
}

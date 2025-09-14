<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Content\Comment;
use App\Models\Content\Media;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public $cachedCategories = [];

    public function storeImage(string $imageUrl, int $modelId, $collection = 'product_images')
    {
        try {
            $response = Http::get($imageUrl);
            if (! $response->successful()) {
                return;
            }
            $imageContents = $response->body();
            $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
            $imageName = 'product-'.Str::uuid().'.'.$extension;
            $path = "products/$imageName";
            if (! Storage::put($path, $imageContents)) {
                return;
            }
            Media::factory()->create([
                'model_type' => Product::class,
                'model_id' => $modelId,
                'path' => $path,
                'directory' => 'products',
                'filename' => $imageName,
                'collection' => $collection,
                'extension' => $extension,
                'mime_type' => Storage::mimeType($path),
                'size_bytes' => Storage::fileSize($path),
            ]);
        } catch (Exception $e) {
            // Handle exceptions if needed
            Log::error('Failed to fetch image: '.$e->getMessage());
        }
    }

    public function run(): void
    {
        $vendors = User::query()->where('role', 'vendor')->limit(10)->get();
        $products = DatabaseSeeder::getData('products', 'products');

        $perVendorProducts = (int) ceil(count($products) / $vendors->count());

        // chunk the products per vendor
        $chunkedProducts = collect($products)->chunk($perVendorProducts);

        // set max progress
        $this->command->getOutput()->progressStart(count($products));

        $chunkedProducts->each(function (Collection $chunk, $index) use ($vendors) {
            $vendor = $vendors[$index % $vendors->count()];
            $chunk->each(function ($product) use ($vendor) {
                $p = Product::factory()->create([
                    'user_id' => $vendor->id,
                    'name' => $product['title'],
                    'slug' => Str::slug($product['title']).'-'.Str::random(5),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => $product['price'],
                    'attributes' => [
                        'brand' => $product['brand'] ?? null,
                        'category' => $product['category'] ?? null,
                        'rating' => $product['rating'] ?? 0,
                        'stock' => $product['stock'] ?? 0,
                    ],
                ]);
                $p = Product::find($p->id); // reload to get the casts
                // attach categories if exists
                if (! empty($product['category'])) {
                    $categoryId = $this->getCategory($product['category']);
                    $p->categories()->syncWithoutDetaching([$categoryId]);
                }
                // add product images
                foreach ($product['images'] as $imageUrl) {
                    $this->storeImage($imageUrl, $p->id);
                }

                // add feature image
                if (! empty($product['thumbnail'])) {
                    $this->storeImage($product['thumbnail'], $p->id, 'thumbnail');
                }

                // store the product reviews
                foreach ($product['reviews'] ?? [] as $review) {
                    Comment::factory()->create([
                        'model_type' => Product::class,
                        'model_id' => $p->id,
                        'rating' => $review['rating'] ?? 5,
                        'comment' => $review['comment'] ?? fake()->sentence(),
                    ]);
                }

                // store product tags
                foreach ($product['tags'] ?? [] as $tag) {
                    $p->tags()->firstOrCreate(
                        ['slug' => Str::slug($tag)],
                        ['name' => ucwords($tag)],
                    );
                }

                $this->command->getOutput()->progressAdvance(); // move the bar one step
            });
        });

        $this->command->getOutput()->progressFinish();
    }

    public function getCategory($categoryName): int
    {
        if (isset($this->cachedCategories[$categoryName])) {
            return $this->cachedCategories[$categoryName];
        }
        $category = Category::firstOrCreate([
            'slug' => Str::slug($categoryName),
            'parent_id' => null,
        ], [
            'name' => ucwords($categoryName),
            'description' => fake()->sentence(),
            'is_active' => true,
        ]);
        $this->cachedCategories[$categoryName] = $category->id;

        return $category->id;
    }
}

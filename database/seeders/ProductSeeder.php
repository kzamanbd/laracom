<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SplFileInfo;

class ProductSeeder extends Seeder
{
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
                Media::factory()->count(fake()->numberBetween(3, 4))->create($this->getMediaData($p));
                // add feature image
                Media::factory()->create($this->getMediaData($p, 'product_feature'));
                $attachIds = $allCategoryIds->shuffle()->take(fake()->numberBetween(1, 3))->all();
                $p->categories()->syncWithoutDetaching($attachIds);
            });
            $allProducts = $allProducts->merge($vendorProducts);
        }
    }

    public function getMediaData(Product $product, string $collection = 'product_images'): array
    {
        $media = $this->productImage();
        $path = Storage::putFile('products', $media->getRealPath());
        return [
            'model_type' => Product::class,
            'model_id' => $product->id,
            'collection' => $collection,
            'directory' => 'products',
            'filename' => $media->getFilename(),
            'extension' => $media->getExtension(),
            'mime_type' => File::mimeType($media->getRealPath()),
            'path' => $path,
            'size_bytes' => $media->getSize(),
        ];
    }

    public static function productImage(): SplFileInfo
    {
        $shopDir = public_path('assets/imgs/shop');
        $files = File::allFiles($shopDir);
        $productImages = [];
        foreach ($files as $file) {
            $name = $file->getRelativePathname();
            if (Str::startsWith($name, 'product-')) {
                $productImages[] = $file;
            }
        }
        return fake()->randomElement($productImages);
    }
}

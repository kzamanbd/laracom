<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Content\Media;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SplFileInfo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            AddressSeeder::class,
            TaxSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PromotionSeeder::class,
            OrderSeeder::class,
            PostSeeder::class,
        ]);
    }

    public static function createMedia(Model $model, array $args = []): void
    {
        $defaultArgs = [
            'directory' => 'others',
            'collection' => 'images',
            'pattern' => null,
            'root' => 'shop',
            'total' => 1,
        ];
        $args = array_merge($defaultArgs, $args);

        $media = self::media($args['root'], $args['pattern']);

        if (! $media) {
            return;
        }

        $originalFilename = $media->getFilename();
        $storagePath = Storage::putFileAs($args['directory'], $media->getRealPath(), $originalFilename);

        $data = [
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'path' => $storagePath,
            'directory' => $args['directory'],
            'filename' => $originalFilename,
            'collection' => $args['collection'],
            'extension' => $media->getExtension(),
            'mime_type' => File::mimeType($media->getRealPath()),
            'size_bytes' => $media->getSize(),
        ];
        // Create media records
        Media::factory()->count($args['total'])->create($data);
    }

    public static function media($directory, $pattern): SplFileInfo
    {
        $shopDir = public_path("assets/imgs/$directory");
        $files = File::allFiles($shopDir);
        $productImages = [];
        foreach ($files as $file) {
            $name = $file->getRelativePathname();
            if (Str::startsWith($name, $pattern)) {
                $productImages[] = $file;
            }
        }

        return fake()->randomElement($productImages);
    }

    public static function getData(string $schema, string $obj = 'data', int $limit = 2000)
    {
        try {
            $response = Http::get("https://dummyjson.com/$schema?limit=$limit");
            $json = $response->json();

            return $json[$obj] ?? $json;
        } catch (Exception $e) {
            return [];
        }
    }
}

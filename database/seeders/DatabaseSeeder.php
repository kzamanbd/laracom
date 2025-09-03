<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SplFileInfo;
use Illuminate\Support\Str;
use InvalidArgumentException;

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
            OrderSeeder::class,
        ]);
    }

    public static function createMedia(Model $model, array $args = []): void
    {
        $directory = $args['directory'] ?? 'others';
        $collection = $args['collection'] ?? 'images';
        $pattern = $args['pattern'];
        $root = $args['root'] ?? 'shop';

        $total = $args['total'] ?? 1;

        if (!$pattern) {
            throw new InvalidArgumentException('Pattern is required to fetch media file.');
        }

        $media = self::media($root, $pattern);

        $originalFilename = $media->getFilename();
        $storagePath = Storage::putFileAs($directory, $media->getRealPath(), $originalFilename);

        $data = [
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'path' => $storagePath,
            'directory' => $directory,
            'filename' => $originalFilename,
            'collection' => $collection,
            'extension' => $media->getExtension(),
            'mime_type' => File::mimeType($media->getRealPath()),
            'size_bytes' => $media->getSize(),
        ];
        // Create media records
        Media::factory()->count($total)->create($data);
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
}

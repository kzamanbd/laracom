<?php

namespace Database\Seeders;

use App\Models\Content\Comment;
use App\Models\Content\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // post data
        $posts = collect(DatabaseSeeder::getData('posts', 'posts'));
        // post comments
        $comments = collect(DatabaseSeeder::getData('comments', 'comments'));

        // set max progress
        $this->command->getOutput()->progressStart(count($posts));

        foreach ($posts as $post) {
            // Create the post
            $post = Post::factory()->create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']).'-'.Str::random(5),
                'content' => $post['body'],
            ]);
            // Create post media
            DatabaseSeeder::createMedia($post, [
                'directory' => 'posts',
                'collection' => 'images',
                'pattern' => 'blog-',
                'root' => 'blog',
            ]);

            // post tags
            if (isset($post['tags']) && is_array($post['tags'])) {
                foreach ($post['tags'] as $tag) {
                    $post->tags()->firstOrCreate(
                        ['slug' => Str::slug($tag)],
                        ['name' => ucwords($tag)]
                    );
                }
            }

            foreach ($comments->where('postId', $post->id) as $comment) {
                Comment::factory()->create([
                    'model_type' => Post::class,
                    'model_id' => $post->id,
                    'comment' => $comment['body'],
                ]);
            }
            $this->command->getOutput()->progressAdvance(); // move the bar one step
        }
        $this->command->getOutput()->progressFinish(); // finish the bar
    }
}

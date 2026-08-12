<?php

namespace App\Console\Commands;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportDummyPosts extends Command
{
    protected $signature = 'app:import-dummy-posts {--count=10 : Number of posts to import}';

    protected $description = 'Import dummy posts from JSONPlaceholder API';

    public function handle()
    {
        $limit = $this->option('count');

        $user = User::first() ?? User::factory()->create([
            'name' => 'Dummy Author',
            'email' => 'dummy@example.com',
        ]);

        $category = Category::first() ?? Category::create([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
        ]);

        $this->info("Fetching {$limit} posts from jsonplaceholder...");

        $response = Http::get('https://jsonplaceholder.typicode.com/posts', [
            '_limit' => $limit,
        ]);

        if ($response->failed()) {
            $this->error('Failed to fetch posts from JSONPlaceholder');
            return 1;
        }

        $posts = $response->collect();

        $bar = $this->output->createProgressBar($posts->count());
        $bar->start();

        $imported = 0;

        foreach ($posts as $data) {
            try {
                Post::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $data['title'],
                    'content' => "<p>" . nl2br(e($data['body'])) . "</p>",
                    'status' => PostStatus::Published,
                    'published_at' => now()->subDays(rand(0, 30)),
                    'views' => rand(0, 1000),
                ]);
                $imported++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->warn("Failed to import post '{$data['title']}': {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Imported {$imported} posts successfully!");

        return 0;
    }
}

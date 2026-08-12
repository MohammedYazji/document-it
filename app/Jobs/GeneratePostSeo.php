<?php

namespace App\Jobs;

use App\Ai\Agents\SeoAgent;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GeneratePostSeo implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $timeout = 120;
    public int $tries = 3;
    public int $maxExceptions = 3;

    public function __construct(
        public Post $post,
    ) {}

    public function handle(SeoAgent $seoAgent): void
    {
        $response = $seoAgent->prompt(
            "Generate SEO metadata for this blog post.\n\nTitle: {$this->post->title}\n\nContent: {$this->post->content}"
        );

        $seo = $response->structured;

        $this->post->updateQuietly([
            'excerpt' => $seo['summary'] ?? $this->post->excerpt,
            'meta' => [
                'title' => $seo['title'] ?? $this->post->title,
                'description' => $seo['description'] ?? null,
                'keywords' => $seo['keywords'] ?? null,
            ],
        ]);

        Log::info('SEO generated for post '.$this->post->id);
    }

    public function failed(\Throwable $exception): void
    {
        Log::warning('SEO generation failed permanently for post '.$this->post->id, [
            'error' => $exception->getMessage(),
        ]);
    }
}

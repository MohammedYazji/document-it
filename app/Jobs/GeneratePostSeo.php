<?php

namespace App\Jobs;

use App\Ai\Agents\SeoAgent;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GeneratePostSeo implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Post $post,
    ) {}

    public function handle(SeoAgent $seoAgent): void
    {
        try {
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
        } catch (\Throwable $e) {
            Log::warning('SEO generation failed for post '.$this->post->id, [
                'error' => $e->getMessage(),
            ]);
        }
    }
}

<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Embeddings;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Image;

class GeneratePostCoverImage implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Post $post,
    ) {}

    public function handle(): void
    {
        try {
            $response = Image::of("Create a cover image for an article/post titled: {$this->post->title}. The aspect ratio should be 19:9 with min width 1024px.")
                ->generate(provider: Lab::Gemini, model: 'gemini-2.5-flash-image');

            $generatedPath = $response->storePublicly('covers', 'public');

            $this->post->updateQuietly(['cover_image' => $generatedPath]);

            $response = Embeddings::for([$this->post->content])
                ->generate(provider: Lab::Gemini, model: 'gemini-embedding-001');

            $this->post->updateQuietly(['embedding' => $response->embeddings[0]]);
        } catch (\Throwable $e) {
            Log::warning('Cover image generation failed for post '.$this->post->id.', using default', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}

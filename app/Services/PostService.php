<?php

namespace App\Services;

use App\Actions\FileUpload;
use App\Actions\SyncTags;
use App\Ai\Agents\SeoAgent;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Embeddings;
use Laravel\Ai\Image;
use RuntimeException;

class PostService
{
    public function __construct(
        protected FileUpload $fileUpload,
        protected SyncTags $syncTags,
        protected SeoAgent $seoAgent,
    ) {}

    public function create(array $data, ?string $tagsInput = null): Post
    {
        $coverImagePath = $this->fileUpload->handle('cover_image', 'covers');

        try {
            return DB::transaction(function () use ($data, $coverImagePath, $tagsInput) {
                $post = Post::create(array_merge($data, [
                    'cover_image' => $coverImagePath,
                ]));

                $this->syncTags->handle($post, $tagsInput);

                $metaProvided = filled($data['meta']['title'] ?? null) || filled($data['meta']['description'] ?? null) || filled($data['meta']['keywords'] ?? null);

                if (! $metaProvided) {
                    try {
                        $response = $this->seoAgent->prompt(
                            "Generate SEO metadata for this blog post.\n\nTitle: {$post->title}\n\nContent: {$post->content}"
                        );

                        $seo = $response->structured;

                        $post->updateQuietly([
                            'excerpt' => $seo['summary'] ?? $post->excerpt,
                            'meta' => [
                                'title' => $seo['title'] ?? $post->title,
                                'description' => $seo['description'] ?? null,
                                'keywords' => $seo['keywords'] ?? null,
                            ],
                        ]);
                    } catch (\Throwable $e) {
                        Log::warning('SEO metadata generation failed', [
                            'post_id' => $post->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }

                // if i save the post then there's no image so generate it using AI
                // TODO: make all ai api calls as jobs in background
                if (! $coverImagePath) {
                    try {
                        $response = Image::of("Create a cover image for an article/post titled: {$post->title}. The aspect ratio should be 19:9 with min width 1024px.")
                            ->generate(provider: Lab::Gemini, model: 'gemini-2.5-flash-image');

                        $generatedPath = $response->storePublicly('covers', 'public');

                        $post->updateQuietly(['cover_image' => $generatedPath]);

                        $response = Embeddings::for([$post->content])
                            ->generate(provider: Lab::Gemini, model: 'gemini-embedding-001');

                        $post->updateQuietly(['embedding' => $response->embeddings[0]]);
                    } catch (\Throwable $e) {
                        Log::warning('Cover image generation failed', [
                            'post_id' => $post->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }



                return $post;
            });
        } catch (\Throwable $e) {
            if ($coverImagePath) {
                Storage::disk('public')->delete($coverImagePath);
            }

            Log::error('Post creation failed', [
                'error' => $e->getMessage(),
                'data'  => $data,
            ]);

            throw new RuntimeException('Failed to create post: ' . $e->getMessage());
        }
    }
}

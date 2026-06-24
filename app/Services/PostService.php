<?php

namespace App\Services;

use App\Actions\FileUpload;
use App\Actions\SyncTags;
use App\Ai\Agents\SeoAgent;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

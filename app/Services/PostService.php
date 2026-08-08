<?php

namespace App\Services;

use App\Actions\FileUpload;
use App\Actions\SyncTags;
use App\Jobs\GeneratePostCoverImage;
use App\Jobs\GeneratePostSeo;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class PostService
{
    public function __construct(
        protected FileUpload $fileUpload,
        protected SyncTags $syncTags,
    ) {}

    public function create(array $data, ?string $tagsInput = null): Post
    {
        $validated = Validator::validate($data, [
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string',
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'meta' => 'nullable|array',
            'meta.title' => 'nullable|string|max:255',
            'meta.description' => 'nullable|string|max:500',
            'meta.keywords' => 'nullable|string|max:255',
            'generate_image' => 'nullable|boolean',
        ]);

        $generateImage = $validated['generate_image'] ?? false;
        unset($validated['generate_image']);

        $coverImagePath = $this->fileUpload->handle('cover_image', 'covers');

        try {
            return DB::transaction(function () use ($validated, $coverImagePath, $tagsInput, $generateImage) {
                $post = Post::create(array_merge($validated, [
                    'cover_image' => $coverImagePath,
                ]));

                $this->syncTags->handle($post, $tagsInput);

                $metaProvided = filled($validated['meta']['title'] ?? null)
                    || filled($validated['meta']['description'] ?? null)
                    || filled($validated['meta']['keywords'] ?? null);

                if (! $metaProvided) {
                    GeneratePostSeo::dispatch($post);
                }

                if (! $coverImagePath && $generateImage) {
                    GeneratePostCoverImage::dispatch($post);
                }

                return $post;
            });
        } catch (\Throwable $e) {
            if ($coverImagePath) {
                Storage::disk('public')->delete($coverImagePath);
            }

            Log::error('Post creation failed', [
                'error' => $e->getMessage(),
                'data' => $validated,
            ]);

            throw new RuntimeException('Failed to create post: '.$e->getMessage());
        }
    }
}

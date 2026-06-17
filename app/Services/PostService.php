<?php

namespace App\Services;

use App\Actions\FileUpload;
use App\Actions\SyncTags;
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

<?php

namespace App\Actions;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

class SyncTags
{
    /**
     * Parse comma-separated tags, find or create by slug, and sync on the post.
     */
    public function handle(Post $post, ?string $tags): void
    {
        if ($tags === null || trim($tags) === '') {
            $post->tags()->sync([]);

            return;
        }

        $tagIds = collect(explode(',', $tags))
            ->map(fn (string $name) => trim($name))
            ->filter()
            ->unique()
            ->map(function (string $name) {
                $slug = Str::slug($name);

                if ($slug === '') {
                    return null;
                }

                $tag = Tag::query()->firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );

                return $tag->id;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();

        $post->tags()->sync($tagIds);
    }
}

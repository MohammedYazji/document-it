<?php

namespace App\Actions;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

class SyncTags
{
    public function handle(Post $post, ?string $tags): void
    {
        if ($tags === null || trim($tags) === '') {
            $post->tags()->detach();

            return;
        }

        $tagIds = collect(explode(',', $tags))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->map(function (string $name) {
                return Tag::firstOrCreate([
                    'slug' => Str::slug($name),
                ], [
                    'name' => $name,
                ])->id;
            });

        $post->tags()->sync($tagIds);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        "title",
        "content",
        "slug",
        "user_id",
        "category_id",
        "status",
        "views",
        "excerpt",
        "cover_image",
    ];

    /** The category this post belongs to */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'uncategorized',
            'slug' => 'uncategorized',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function content(): Attribute
    {
        return new Attribute(
            set: fn($value) => strip_tags($value, '<script><h1>')
        );
    }

    public function title(): Attribute
    {
        return new Attribute(
            get: fn($value) => ucwords($value)
        );
    }

    public function thumbnailUrl(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->cover_image) {
                return Storage::disk('public')->url($this->cover_image);
            }

            return asset('images/default-thumbnail.png');
        });
    }
}

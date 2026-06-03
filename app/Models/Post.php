<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $casts = [
        "published_at"=> "datetime",
        "meta" => "json",
        "status" => PostStatus::class,
    ];

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
        "published_at",
        "meta",
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

    public function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value) : $this->created_at,
            set: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }
}

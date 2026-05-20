<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->belongsTo(Category::class);
    }
}

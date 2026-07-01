<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Http\Resources\PostResource;
use App\Models\Scopes\OwnerScope;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[ScopedBy(OwnerScope::class)]
#[ObserverBy(PostObserver::class)]
#[UserResource(PostResource::class)]
class Post extends Model
{
    use HasFactory;
    use Prunable;
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'posts';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'slug',
        'excerpt',
        'cover_image',
        'status',
        'views',
        'published_at',
        'meta',
        'embedding',
    ];

    protected $appends = [
        'thumbnail_url',
        'publish_time',
        'read_time',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'meta' => 'json',
            'status' => PostStatus::class,
            'embedding' => 'array',
        ];
    }

    protected static function booted()
    {
        Builder::macro('selectVectorDistance', function (string $column, array $vector, string $alias) {
            return $this->selectRaw('*, VECTOR_DISTANCE(?, CAST(? AS VECTOR)) AS '.$alias, [$column, json_encode($vector)]);
        });

        Builder::macro('whereVectorSimilarTo', function (string $column, array $vector, float $threshold) {
            return $this->having('distance', '<', $threshold);
        });

        Builder::macro('orderByVectorDistance', function (string $column, array $vector) {
            return $this->orderBy('distance');
        });
    }

    public function scopePublished(Builder $builder, string|\DateTime|null $time = null)
    {
        $builder
            // ->withoutGlobalScope('owner')
            ->where('status', PostStatus::Published)
            ->where(function ($query) use ($time) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', $time ?? now());
            });
    }

    public function scopeStatus(Builder $builder, string|PostStatus $status)
    {
        $builder->where('status', $status);
    }

    public function scopeSlug(Builder $builder, string $slug)
    {
        $builder->where('slug', $slug);
    }

    // protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')
            ->withDefault([
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
            ]);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function bookmarkedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    public function content(): Attribute
    {
        return new Attribute(
            set: fn ($value) => strip_tags($value, '<h2><h3><h4><h5><h6><p><a><ul><ol><li><br><strong><em><img><video><audio>'),
        );
    }

    public function title(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strip_tags($value),
        );
    }

    public function thumbnailUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->cover_image
                    ? asset('storage/'.$this->cover_image)
                    : asset('images/default-thumbnail.png');
            }
        );
    }

    public function publishTime(): Attribute
    {
        return new Attribute(
            get: fn () => $this->published_at ?? $this->created_at,
        );
    }

    public function wordCount(): int
    {
        return str_word_count(strip_tags($this->content ?? ''));
    }

    public function readTime(): Attribute
    {
        return Attribute::make(
            get: fn () => (int) ceil($this->wordCount() / 200)
        )->shouldCache();
    }

    public function related(int $limit = 3, bool $sameCategory = false): Collection
    {
        if (! $this->embedding) {
            return $this->legacyRelated($limit, $sameCategory);
        }

        return static::query()
            ->when($sameCategory && $this->category_id, fn ($q) => $q->where('category_id', $this->category_id))
            ->selectVectorDistance('embedding', $this->embedding, 'distance')
            ->whereVectorSimilarTo('embedding', $this->embedding, 0.4)
            ->orderByVectorDistance('embedding', $this->embedding)
            ->limit($limit)
            ->get();
    }

    protected function legacyRelated(int $limit, bool $sameCategory): Collection
    {
        return static::query()
            ->when($sameCategory && $this->category_id, fn ($q) => $q->where('category_id', $this->category_id))
            ->whereHas('tags', function ($query) {
                $query->whereIn('id', $this->tags()->pluck('id')->toArray());
            })
            ->limit($limit)
            ->get();
    }

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }

    protected function pruning(): void
    {
        if ($this->cover_image && Storage::exists($this->cover_image)) {
            Storage::delete($this->cover_image);
        }
    }
}

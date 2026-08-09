@php
    $trending = \App\Models\Post::published()
        ->withCount(['likedBy', 'comments'])
        ->orderByDesc('liked_by_count')
        ->orderByDesc('views')
        ->limit(5)
        ->get();
@endphp

<div class="bg-surface border border-outline-variant rounded-lg p-4 space-y-3">
    <p class="text-xs text-on-surface-variant/50 uppercase tracking-widest">$ trending</p>
    <div class="space-y-3">
        @forelse($trending as $i => $post)
            <a href="{{ route('post.show', $post->slug) }}" class="flex gap-2 group">
                <span class="text-xs text-on-surface-variant/30 shrink-0">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <div class="min-w-0">
                    <p class="text-xs text-on-surface group-hover:text-primary cursor-pointer transition-colors line-clamp-2">{{ $post->title }}</p>
                    <p class="text-[10px] text-on-surface-variant/40 mt-0.5">{{ $post->liked_by_count }}claps · {{ $post->views }}views</p>
                </div>
            </a>
        @empty
            <p class="text-xs text-on-surface-variant/40">no posts yet</p>
        @endforelse
    </div>
</div>

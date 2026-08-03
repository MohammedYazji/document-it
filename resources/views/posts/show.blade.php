<x-layout :title="$post->title">
    <main class="py-6 px-4 max-w-2xl mx-auto space-y-8">
        @auth
            @if(auth()->user()->id === $post->user_id || auth()->user()->is_admin)
                <div class="flex justify-end">
                    <a href="{{ route('posts.edit', $post->id) }}" class="text-sm text-on-surface-variant hover:text-primary transition-colors">$ edit</a>
                </div>
            @endif
        @endauth

        <header class="space-y-4">
            <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                <span class="text-primary font-bold">$ {{ $post->category->name }}</span>
                <span class="text-on-surface-variant/30">|</span>
                <span>{{ $post->publish_time->format('M d, Y') }}</span>
                <span class="text-on-surface-variant/30">|</span>
                <span>{{ $post->read_time }}min</span>
                <span class="text-on-surface-variant/30">|</span>
                <span>{{ $post->views }} views</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-on-surface leading-tight">{{ $post->title }}</h1>
            @if($post->excerpt)
                <p class="text-on-surface-variant">{{ $post->excerpt }}</p>
            @endif
            <div class="flex items-center gap-3 pt-2">
                <div class="w-8 h-8 rounded bg-surface-container border border-outline-variant overflow-hidden">
                    <img alt="" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&color=58a6ff&background=0d1117&size=32" />
                </div>
                <div>
                    <p class="text-sm font-bold text-on-surface">{{ $post->user->name }}</p>
                    <p class="text-xs text-on-surface-variant/50">// author</p>
                </div>
                <x-post-bookmark :post="$post" />
            </div>
        </header>

        <figure class="rounded-lg overflow-hidden border border-outline-variant">
            <img alt="" class="w-full aspect-video object-cover" src="{{ $post->thumbnail_url }}" />
        </figure>

        <article class="prose-terminal text-sm leading-relaxed">{!! $post->content_html !!}</article>

        @if ($relatedPosts->isNotEmpty())
            <section class="pt-6 border-t border-outline-variant">
                <h2 class="text-sm text-on-surface-variant mb-4">$ related</h2>
                <div class="space-y-3">
                    @foreach ($relatedPosts as $related)
                        <x-post-card :post="$related" />
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</x-layout>

<x-layout :title="$post->title">
    <main class="pt-24 pb-section-gap max-w-article-max mx-auto px-gutter space-y-12">
        @auth
            @if(auth()->user()->id === $post->user_id || auth()->user()->is_admin)
                <div class="flex justify-end mb-4">
                    <a href="{{ route('posts.edit', $post->id) }}" class="inline-flex items-center gap-2 bg-primary-container text-on-primary-container px-4 py-2 rounded-lg font-ui-button text-sm hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Post
                    </a>
                </div>
            @endif
        @endauth
        <header class="space-y-6 text-center">
            <div class="flex items-center justify-center gap-3 font-metadata text-metadata text-secondary">
                <span class="text-primary font-bold uppercase tracking-wider">{{ $post->category->name }}</span>
                <span>•</span>
                <span>{{ $post->publish_time->format('M d, Y') }}</span>
                <span>•</span>
                <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
            </div>
            <h1 class="font-display-lg text-[40px] md:text-[56px] leading-tight text-on-surface">
                {{ $post->title }}
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                {{ $post->excerpt }}
            </p>
            <div class="flex items-center justify-center gap-4 pt-4">
                <div class="w-12 h-12 rounded-full bg-surface-container border border-outline-variant overflow-hidden">
                    <img alt="{{ $post->user->name }}" class="w-full h-full object-cover"
                        src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&color=7F9CF5&background=EBF4FF" />
                </div>
                <div class="text-left">
                    <p class="font-ui-label text-ui-label font-bold text-on-surface">{{ $post->user->name }}</p>
                    <p class="font-metadata text-metadata text-secondary">Author</p>
                </div>
            </div>
        </header>

        <figure class="w-full aspect-video rounded-xl overflow-hidden border border-outline-variant">
            <img alt="{{ $post->title }}" class="w-full h-full object-cover" src="{{ $post->thumbnail_url }}" />
        </figure>

        <article class="prose prose-lg max-w-none text-on-surface font-body-md">
            {!! $post->content !!}
        </article>
    </main>
</x-layout>

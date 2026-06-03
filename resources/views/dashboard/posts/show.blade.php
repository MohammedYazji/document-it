<x-layout title="{{ $post->title }}">
    <x-slot:style>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 200, 'GRAD' 0, 'opsz' 24;
                vertical-align: middle;
            }

            body {
                background-color: #f9f9f9;
                color: #1a1c1c;
            }

            .post-content {
                white-space: pre-wrap;
            }
        </style>
    </x-slot:style>

    <main class="flex-grow w-full max-w-article-max mx-auto px-gutter py-12 pt-24">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('posts.index') }}"
                class="inline-flex items-center gap-2 font-ui-label text-ui-label text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Back to posts
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('posts.edit', $post->id) }}"
                    class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-ui-button text-ui-button hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                    Edit
                </a>
            </div>
        </div>

        <article class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden">
            <div class="aspect-[16/9] w-full overflow-hidden border-b border-outline-variant">
                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover" />
            </div>

            <div class="p-8 md:p-12 space-y-6">
                <div class="flex flex-wrap items-center gap-3 font-metadata text-metadata text-on-surface-variant">
                    <span class="text-primary font-semibold">{{ $post->category->name }}</span>
                    <span>•</span>
                    <time datetime="{{ $post->published_at->toDateString() }}">
                        {{ $post->published_at->format('M d, Y') }}
                    </time>
                    <span>•</span>
                    <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                        {{ $post->views ?? 0 }}
                    </span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">chat_bubble</span>
                        {{ $post->comments_count }}
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-{{ $post->status->getColor() }}-50 text-{{ $post->status->getColor() }}-700 text-[12px] font-bold border border-{{ $post->status->getColor() }}-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-{{ $post->status->getColor() }}-600"></span> {{ $post->status->getLabel() }}
                    </span>
                </div>

                <h1 class="font-display-lg text-display-lg text-on-background leading-tight">
                    {{ $post->title }}
                </h1>

                @if ($post->published_at)
                    <div class="font-metadata text-metadata text-on-surface-variant">
                        Published at: <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('M d, Y h:i A') }}</time>
                    </div>
                @endif

                @if ($post->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($post->tags as $tag)
                            <span
                                class="bg-primary-fixed text-on-primary-fixed px-3 py-1 rounded-full font-metadata text-metadata">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <div class="post-content font-body-lg text-body-lg text-on-surface leading-relaxed border-t border-outline-variant pt-8">
                        {!! $post->content !!}
                </div>
            </div>
        </article>
    </main>
</x-layout>

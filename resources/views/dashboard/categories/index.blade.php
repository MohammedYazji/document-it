<x-layout title="Categories">
    <main class="py-6 px-4 max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-end justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-on-surface">Categories</h1>
                <p class="text-sm text-on-surface-variant mt-1">$ organize your content</p>
            </div>
            <a href="{{ route('categories.create') }}" class="bg-primary text-on-primary px-4 py-2 rounded text-sm hover:opacity-90 transition-opacity shrink-0">
                $ new
            </a>
        </div>

        @if (session('success'))
            <div class="p-3 bg-primary/10 border border-primary/30 rounded text-sm text-on-surface">
                <span class="text-primary">//</span> {{ session('success') }}
            </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @php
                $total = $categories->count();
                $topLevel = $categories->whereNull('parent_id')->count();
                $nested = $categories->whereNotNull('parent_id')->count();
                $withPosts = $categories->filter(fn($c) => $c->posts_count > 0 || $c->posts->count() > 0)->count();
            @endphp
            <div class="bg-surface border border-outline-variant rounded-lg p-3">
                <p class="text-xs text-on-surface-variant">$ total</p>
                <p class="text-lg font-bold text-on-surface">{{ $total }}</p>
            </div>
            <div class="bg-surface border border-outline-variant rounded-lg p-3">
                <p class="text-xs text-on-surface-variant">$ top_level</p>
                <p class="text-lg font-bold text-on-surface">{{ $topLevel }}</p>
            </div>
            <div class="bg-surface border border-outline-variant rounded-lg p-3">
                <p class="text-xs text-on-surface-variant">$ nested</p>
                <p class="text-lg font-bold text-on-surface">{{ $nested }}</p>
            </div>
            <div class="bg-surface border border-outline-variant rounded-lg p-3">
                <p class="text-xs text-on-surface-variant">$ with_posts</p>
                <p class="text-lg font-bold text-on-surface">{{ $withPosts }}</p>
            </div>
        </div>

        <!-- List -->
        <div class="space-y-1">
            @forelse ($categories as $category)
                <div class="flex items-center gap-3 p-3 rounded-lg border border-outline-variant bg-surface hover:border-primary transition-colors group">
                    <div class="w-6 h-6 rounded bg-primary/10 flex items-center justify-center shrink-0">
                        <span class="text-primary text-xs">{{ $category->parent_id ? '>' : '#' }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-on-surface">{{ $category->name }}</p>
                        @if ($category->parent)
                            <p class="text-xs text-on-surface-variant/50">under {{ $category->parent->name }}</p>
                        @endif
                    </div>
                    <code class="text-xs text-on-surface-variant bg-surface-container px-2 py-0.5 rounded border border-outline-variant">{{ $category->slug }}</code>
                    <span class="text-xs text-on-surface-variant/50 shrink-0">{{ $category->posts->count() }} posts</span>
                    <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('categories.edit', $category->id) }}" class="px-2 py-1 text-xs text-on-surface-variant hover:text-primary rounded transition-colors">edit</a>
                        <button type="button" onclick="openDeleteModal('{{ Str::slug($category->name) }}')" class="px-2 py-1 text-xs text-error hover:text-error rounded transition-colors">del</button>
                    </div>
                </div>

                <x-delete-modal :name="$category->name" type="category" />

                <form id="delete-form-{{ Str::slug($category->name) }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            @empty
                <div class="py-12 text-center border border-dashed border-outline-variant rounded-lg">
                    <p class="text-sm text-on-surface-variant">No categories yet</p>
                    <a href="{{ route('categories.create') }}" class="text-sm text-primary hover:underline mt-2 inline-block">$ create first</a>
                </div>
            @endforelse
        </div>
    </main>
</x-layout>

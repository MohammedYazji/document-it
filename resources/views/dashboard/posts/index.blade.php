<x-layout title="Dashboard">
    <main class="py-6 px-4 max-w-5xl mx-auto space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">Dashboard</h1>
            <p class="text-sm text-on-surface-variant mt-1">$ manage your posts</p>
        </div>

        <div class="flex gap-4 border-b border-outline-variant pb-2 overflow-x-auto text-sm">
            <x-tab :href="route('posts.index', ['status' => 'all'])" :active="$status === 'all'" :count="$posts_all->count()">all</x-tab>
            <x-tab :href="route('posts.index', ['status' => 'published'])" :active="$status === 'published'" :count="$posts_all->where('status', 'published')->count()">published</x-tab>
            <x-tab :href="route('posts.index', ['status' => 'draft'])" :active="$status === 'draft'" :count="$posts_all->where('status', 'draft')->count()">drafts</x-tab>
            <x-tab :href="route('posts.index', ['status' => 'archived'])" :active="$status === 'archived'" :count="$posts_all->where('status', 'archived')->count()">archived</x-tab>
        </div>

        <div class="space-y-2">
            @forelse ($posts as $post)
                <div class="flex items-center gap-4 p-3 rounded-lg border {{ $post->trashed() ? 'border-yellow-500/30 bg-yellow-500/5' : 'border-outline-variant bg-surface' }} hover:border-primary transition-colors group">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 text-xs text-on-surface-variant mb-1">
                            @if($post->trashed())
                                <span class="text-yellow-400 font-bold">trashed</span>
                                <span class="text-on-surface-variant/30">|</span>
                            @else
                                <span class="text-primary">{{ $post->category->name }}</span>
                                <span class="text-on-surface-variant/30">|</span>
                                <span>{{ $post->published_at?->format('M d, Y') }}</span>
                                <span class="text-on-surface-variant/30">|</span>
                                <span class="px-1.5 py-0.5 rounded text-[10px] {{ $post->status->getColor() === 'green' ? 'text-primary bg-primary/10' : 'text-on-surface-variant bg-surface-container' }}">{{ $post->status->getLabel() }}</span>
                            @endif
                        </div>
                        <span class="text-sm font-bold {{ $post->trashed() ? 'text-on-surface-variant' : 'text-on-surface group-hover:text-primary' }} transition-colors">{{ $post->title }}</span>
                    </div>
                    <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                        @if($post->trashed())
                            <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-2 py-1 text-xs text-primary hover:text-primary rounded transition-colors">restore</button>
                            </form>
                            <button type="button" onclick="openDeleteModal('{{ Str::slug($post->title) }}')" class="px-2 py-1 text-xs text-error hover:text-error rounded transition-colors">delete</button>

                            <x-delete-modal :name="$post->title" type="post permanently" />

                            <form id="delete-form-{{ Str::slug($post->title) }}" action="{{ route('posts.forceDelete', $post->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        @else
                            <a href="{{ route('posts.edit', $post->id) }}" class="px-2 py-1 text-xs text-on-surface-variant hover:text-primary rounded transition-colors">edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Trash this post?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-2 py-1 text-xs text-on-surface-variant hover:text-error rounded transition-colors">trash</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center border border-dashed border-outline-variant rounded-lg">
                    <p class="text-sm text-on-surface-variant">No posts yet</p>
                    <a href="{{ route('posts.create') }}" class="text-sm text-primary hover:underline mt-2 inline-block">$ write first post</a>
                </div>
            @endforelse
        </div>

        @if ($posts->isNotEmpty())
            <div>{{ $posts->links() }}</div>
        @endif
    </main>
</x-layout>

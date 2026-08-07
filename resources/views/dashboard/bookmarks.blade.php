<x-layout title="Bookmarks">
    <main class="py-6 px-4 max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">Bookmarks</h1>
            <p class="text-sm text-on-surface-variant mt-1">$ saved posts</p>
        </div>

        <div class="space-y-3">
            @forelse ($bookmarks as $post)
                <x-post-card :post="$post" />
            @empty
                <div class="py-12 text-center border border-dashed border-outline-variant rounded-lg">
                    <p class="text-sm text-on-surface-variant">$ no bookmarks yet</p>
                    <p class="text-xs text-on-surface-variant/50 mt-1">click [*] on any post to save it</p>
                </div>
            @endforelse
        </div>

        @if ($bookmarks->isNotEmpty())
            <div>{{ $bookmarks->links() }}</div>
        @endif
    </main>
</x-layout>

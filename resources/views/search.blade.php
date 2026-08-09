<x-layout title="Search: {{ $query }}">
    <main class="py-6 px-4 max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">
                <span class="text-on-surface-variant/50">$</span> search
            </h1>
            @if($query)
                <p class="text-sm text-on-surface-variant mt-1">
                    results for "<span class="text-primary">{{ $query }}</span>"
                </p>
            @endif
        </div>

        {{-- Search form --}}
        <form action="{{ route('search') }}" method="GET" class="flex gap-2">
            <div class="flex-1 flex items-center bg-surface border border-outline-variant rounded px-3 py-2 gap-2">
                <span class="text-on-surface-variant/40 text-sm">></span>
                <input name="q" value="{{ $query }}" class="bg-transparent border-none focus:ring-0 text-on-surface text-sm flex-1 placeholder:text-on-surface-variant/30 outline-none" placeholder="search posts..." type="text" autofocus />
            </div>
            <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded text-sm hover:opacity-90 transition-opacity">
                $ search
            </button>
        </form>

        {{-- Results --}}
        @if($query && $posts->isNotEmpty())
            <div class="space-y-3">
                @foreach($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            <div class="pt-4">{{ $posts->links() }}</div>
        @elseif($query)
            <div class="py-12 text-center border border-outline-variant rounded-lg bg-surface">
                <p class="text-on-surface-variant"><span class="text-error">!</span> No results for "{{ $query }}"</p>
            </div>
        @endif
    </main>
</x-layout>

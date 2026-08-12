<x-layout title="Search: {{ $query }}">
    <main class="py-6 px-4 max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">
                <span class="text-on-surface-variant/50">$</span> search
            </h1>
            @if($query)
                <p class="text-sm text-on-surface-variant mt-1">
                    results for "<span class="text-primary">{{ $query }}</span>"
                    @if($smart)
                        <span class="text-primary/60">[AI expanded]</span>
                    @endif
                </p>
            @endif
            <p class="text-[10px] text-on-surface-variant/40 mt-1">type <span class="text-primary">smart/</span> before query for AI search (titles only)</p>
        </div>

        {{-- Search form --}}
        <form action="{{ route('search') }}" method="GET" class="flex items-center bg-surface border border-outline-variant rounded px-3 py-2 gap-2 font-mono text-xs">
            <span class="text-primary">~/</span>
            <input name="q" value="{{ $input ?? $query }}" class="bg-transparent border-none focus:ring-0 text-on-surface flex-1 placeholder:text-on-surface-variant/30 outline-none" placeholder="search or smart search..." type="text" autofocus />
            <button type="submit" class="text-primary hover:text-primary/80 transition-colors">></button>
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

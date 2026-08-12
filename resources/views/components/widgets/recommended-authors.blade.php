<div class="bg-surface border border-outline-variant rounded-lg p-4 space-y-3">
    <p class="text-xs text-on-surface-variant/50 uppercase tracking-widest">$ {{ $title ?? 'authors' }}</p>
    @foreach ($authors ?? [] as $author)
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 min-w-0">
                <div class="w-5 h-5 rounded bg-surface-container border border-outline-variant flex items-center justify-center shrink-0">
                    <span class="text-[10px] text-on-surface-variant">@</span>
                </div>
                <span class="text-xs text-on-surface truncate">{{ $author->name }}</span>
            </div>
            @auth
                @if ($author->is_followed)
                    <form method="POST" action="{{ route('follow.destroy') }}">
                        @csrf @method('DELETE')
                        <input type="hidden" name="user_id" value="{{ $author->id }}">
                        <button type="submit" class="text-[10px] text-on-surface-variant hover:text-primary transition-colors">unfollow</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('follow.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $author->id }}">
                        <button type="submit" class="text-[10px] text-primary hover:underline transition-colors">follow</button>
                    </form>
                @endif
            @endauth
        </div>
    @endforeach
</div>

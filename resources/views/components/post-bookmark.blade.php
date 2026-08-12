@props(['post'])

@auth
    @php $isBookmarked = $post->bookmarkedBy()->where('user_id', auth()->id())->exists(); @endphp
    <form method="POST" action="{{ $isBookmarked ? route('bookmarks.destroy') : route('bookmarks.store') }}" class="inline">
        @csrf
        @if($isBookmarked) @method('DELETE') @endif
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <button type="submit" class="text-xs flex items-center gap-1.5 {{ $isBookmarked ? 'text-primary' : 'text-on-surface-variant/50 hover:text-primary' }} transition-colors">
            <span>{{ $isBookmarked ? '[*]' : '[ ]' }}</span>
            <span>{{ $isBookmarked ? 'bookmarked' : 'bookmark' }}</span>
        </button>
    </form>
@endauth

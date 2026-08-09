@props(['post'])

@auth
    @php $isLiked = $post->likedBy()->where('user_id', auth()->id())->exists(); @endphp
    <form method="POST" action="{{ $isLiked ? route('likes.destroy') : route('likes.store') }}" class="inline">
        @csrf
        @if($isLiked) @method('DELETE') @endif
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <button type="submit" class="flex items-center gap-1 text-xs {{ $isLiked ? 'text-primary' : 'text-on-surface-variant/40 hover:text-primary' }} transition-colors" onclick="event.stopPropagation()">
            <span>{{ $isLiked ? '👏' : '👏' }}</span>
            <span>{{ $post->likedBy()->count() }}</span>
        </button>
    </form>
@endauth

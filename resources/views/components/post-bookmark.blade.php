@props(['post'])

@auth
    @php
        $isBookmarked = $post->bookmarkedBy()->where('user_id', auth()->id())->exists();
    @endphp
    <form method="POST" action="{{ $isBookmarked ? route('bookmarks.destroy') : route('bookmarks.store') }}" class="inline-flex">
        @csrf
        @if($isBookmarked)
            @method('DELETE')
        @endif
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <button type="submit"
            class="p-2 rounded-full hover:bg-primary-container/10 transition-colors {{ $isBookmarked ? 'text-primary' : 'text-secondary' }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $isBookmarked ? 1 : 0 }};">bookmark</span>
        </button>
    </form>
@endauth

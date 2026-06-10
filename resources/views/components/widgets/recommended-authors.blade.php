<div class="space-y-6">
    <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">{{ $title }}</h3>
    <div class="space-y-4">
        @foreach ($authors as $author)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img alt="{{ $author->name }}" class="w-10 h-10 rounded-full object-cover"
                        src="{{ $author->avatoar ?? 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&color=7F9CF5&background=EBF4FF' }}" />
                    <div>
                        <p class="font-ui-label text-ui-label font-bold text-on-surface">{{ $author->name }}</p>
                        <p class="font-metadata text-metadata text-secondary">{{ $author->username ? '@' . $author->username : 'Author' }}</p>
                    </div>
                </div>
                @auth
                    @if ($author->is_followed)
                        <form method="POST" action="{{ route('follow.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" value="{{ $author->id }}">
                            <button type="submit"
                                class="px-3 py-1 border border-on-surface text-on-surface rounded-full font-metadata text-metadata font-bold hover:bg-on-surface hover:text-white transition-all">Unfollow</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('follow.store') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $author->id }}">
                            <button type="submit"
                                class="px-3 py-1 border border-on-surface text-on-surface rounded-full font-metadata text-metadata font-bold hover:bg-on-surface hover:text-white transition-all">Follow</button>
                        </form>
                    @endif
                @endauth
            </div>
        @endforeach
        {{-- <a class="block font-ui-label text-ui-label text-primary font-bold hover:underline" href="#">View all recommendations</a> --}}
    </div>
</div>

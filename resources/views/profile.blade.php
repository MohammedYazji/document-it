<x-layout :title="$user->name">
    <main class="py-6 px-4 max-w-3xl mx-auto space-y-6">
        {{-- Profile Header --}}
        <div class="flex items-start gap-6">
            <div class="w-20 h-20 rounded-lg bg-surface-container border border-outline-variant overflow-hidden shrink-0">
                <img alt="" class="w-full h-full object-cover" src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=58a6ff&background=0d1117&size=80' }}" />
            </div>
            <div class="flex-1 space-y-3">
                <div>
                    <h1 class="text-xl font-bold text-on-surface">{{ $user->name }}</h1>
                    <p class="text-sm text-on-surface-variant">{{ '@' . $user->username }}</p>
                </div>
                <div class="flex items-center gap-4 text-sm text-on-surface-variant">
                    <span><span class="font-bold text-on-surface">{{ $user->posts_count }}</span> posts</span>
                    <span><span class="font-bold text-on-surface">{{ $user->followers_count }}</span> followers</span>
                    <span><span class="font-bold text-on-surface">{{ $user->followings_count }}</span> following</span>
                </div>
                @auth
                    @if(auth()->id() !== $user->id)
                        <form method="POST" action="{{ $isFollowing ? route('follow.destroy') : route('follow.store') }}" class="inline">
                            @csrf
                            @if($isFollowing) @method('DELETE') @endif
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="px-4 py-1.5 text-sm rounded transition-colors {{ $isFollowing ? 'bg-surface-container border border-outline-variant text-on-surface-variant hover:text-error' : 'bg-primary text-on-primary hover:opacity-90' }}">
                                $ {{ $isFollowing ? 'unfollow' : 'follow' }}
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Posts --}}
        <div class="border-t border-outline-variant pt-6">
            <h2 class="text-sm text-on-surface-variant/50 uppercase tracking-widest mb-4">$ posts</h2>
            <div class="space-y-3">
                @forelse ($posts as $post)
                    <x-post-card :post="$post" />
                @empty
                    <p class="text-sm text-on-surface-variant text-center py-8">No posts yet</p>
                @endforelse
            </div>
            @if ($posts->isNotEmpty())
                <div class="mt-6">{{ $posts->links() }}</div>
            @endif
        </div>
    </main>
</x-layout>

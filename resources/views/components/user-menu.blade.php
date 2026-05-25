<div class="flex items-center gap-4">
    @auth
        <a href="{{ route('posts.create') }}"
            class="bg-primary-container text-on-primary px-6 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all shadow-sm">
            Create Post
        </a>
        <span class="text-on-surface font-medium text-ui-label">{{ $user->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="text-error hover:text-error-container transition-colors font-medium">
                Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="bg-primary text-on-primary px-6 py-2 rounded-lg font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all shadow-sm">
            Login
        </a>
    @endauth
</div>

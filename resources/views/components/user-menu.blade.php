@auth
    <div class="flex items-center gap-2 px-1">
        <span class="text-xs text-on-surface truncate">{{ $user->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="text-xs text-error hover:text-error transition-colors">[x]</button>
        </form>
    </div>
@else
    <a href="{{ route('login') }}" class="block text-xs text-on-surface-variant hover:text-primary transition-colors">$ login</a>
@endauth

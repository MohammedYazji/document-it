@auth
    <div class="space-y-2">
        <div class="flex items-center justify-between px-1">
            <a href="{{ route('settings') }}" class="text-xs text-on-surface truncate hover:text-primary transition-colors">{{ $user->name }}</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="text-xs text-error hover:text-error transition-colors">[x]</button>
            </form>
        </div>
    </div>
@else
    <a href="{{ route('login') }}" class="block text-xs text-on-surface-variant hover:text-primary transition-colors">$ login</a>
@endauth

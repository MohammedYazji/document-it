<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="theme-color" content="#0d1117">
    @vite('resources/css/app.css')
    {{ $style ?? '' }}
</head>

<body class="font-body-md text-body-md bg-background text-on-surface selection:bg-primary/30 selection:text-primary">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="hidden md:flex flex-col w-48 bg-surface border-r border-outline-variant fixed top-0 left-0 h-full z-40">
            <div class="p-4 border-b border-outline-variant">
                <a class="font-bold text-primary text-base" href="{{route('home')}}">&gt;&gt; {{config('app.name')}}</a>
            </div>
            <nav class="flex-1 p-3 space-y-0.5">
                <a class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('home') ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-colors"
                    href="{{ route('home') }}">
                    $ feed
                </a>
                <a class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('posts.*') ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-colors"
                    href="{{ route('posts.index') }}">
                    $ dashboard
                </a>
                <a class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('categories.*') ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-colors"
                    href="{{ route('categories.index') }}">
                    $ categories
                </a>
                <a class="flex items-center gap-2 px-3 py-2 rounded text-sm text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors"
                    href="#">
                    $ authors
                </a>
                @auth
                    <a class="flex items-center gap-2 px-3 py-2 rounded text-sm text-primary hover:bg-primary/10 transition-colors"
                        href="{{ route('posts.create') }}">
                        $ new post
                    </a>
                @endauth
            </nav>
            <div class="p-3 border-t border-outline-variant">
                <x-user-menu />
            </div>
        </aside>

        <!-- Main Area -->
        <div class="flex-1 md:ml-48 flex flex-col">
            <!-- Top Nav -->
            <header class="sticky top-0 z-50 bg-surface/95 backdrop-blur-sm border-b border-outline-variant h-12">
                <div class="flex justify-between items-center h-full px-4">
                    <div class="flex items-center gap-4">
                        <button id="mobile-menu-btn" class="md:hidden text-on-surface-variant hover:text-primary text-sm">[=]</button>
                        <a href="{{ route('home') }}" class="md:hidden font-bold text-primary text-sm">&gt;&gt;</a>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        @php $unreadCount = Auth::check() ? Auth::user()->unreadNotifications()->count() : 0 @endphp
                        <a href="{{ route('notifications.index') }}" class="text-on-surface-variant hover:text-primary transition-colors">
                            [inbox{{ $unreadCount > 0 ? ' ' . $unreadCount : '' }}]
                        </a>
                        <span class="text-on-surface-variant/30">|</span>
                        <span class="text-on-surface-variant/50">{{ date('D') }}</span>
                    </div>
                </div>
            </header>

            <!-- Mobile Sidebar -->
            <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 md:hidden">
                <div class="absolute inset-0 bg-black/60" id="mobile-sidebar-close"></div>
                <aside class="absolute left-0 top-0 h-full w-48 bg-surface border-r border-outline-variant p-3 space-y-0.5">
                    <div class="mb-3 pb-3 border-b border-outline-variant">
                        <a class="font-bold text-primary text-base" href="{{route('home')}}">&gt;&gt; {{config('app.name')}}</a>
                    </div>
                    <a class="block px-3 py-2 rounded text-sm {{ request()->routeIs('home') ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('home') }}">$ feed</a>
                    <a class="block px-3 py-2 rounded text-sm {{ request()->routeIs('posts.*') ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('posts.index') }}">$ dashboard</a>
                    <a class="block px-3 py-2 rounded text-sm {{ request()->routeIs('categories.*') ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route('categories.index') }}">$ categories</a>
                    <a class="block px-3 py-2 rounded text-sm text-on-surface-variant hover:bg-surface-container" href="#">$ authors</a>
                    @auth
                        <a class="block px-3 py-2 rounded text-sm text-primary hover:bg-primary/10" href="{{ route('posts.create') }}">$ new post</a>
                    @endauth
                </aside>
            </div>

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="border-t border-outline-variant py-6 px-4">
                <div class="max-w-container-max mx-auto flex flex-col sm:flex-row justify-between items-center gap-2 text-sm text-secondary">
                    <span class="text-primary">{{config('app.name')}}</span>
                    <span class="text-on-surface-variant/40">// {{date('Y')}}</span>
                </div>
            </footer>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileClose = document.getElementById('mobile-sidebar-close');
        if (menuBtn) menuBtn.addEventListener('click', () => mobileSidebar.classList.remove('hidden'));
        if (mobileClose) mobileClose.addEventListener('click', () => mobileSidebar.classList.add('hidden'));
    </script>
</body>

</html>

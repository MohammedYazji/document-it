<!DOCTYPE html>

<html class="light" lang="en">

<head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta name="user-id" content="{{ auth()->id() }}">
        @vite('resources/css/app.css')
        <script src="https://cdn.tiny.cloud/1/pfai0o5myakjgxyslwuu2rlzkcdp782oxxhl26nuk74k3kgx/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Source+Serif+4:wght@400;600;700&amp;display=swap"
                rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
                rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
                rel="stylesheet" />
        {{ $style ?? '' }}
</head>

<body class="font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed">
        <!-- TopNavBar -->
        <header class="fixed top-0 z-50 w-full bg-surface border-b border-outline-variant">
                <div class="flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-16">
                        <div class="flex items-center gap-8">
                                <a class="font-display-lg-mobile text-display-lg-mobile font-bold text-on-surface"
                                        href="{{route('home')}}">{{config('app.name')}}</a>
                                <nav class="hidden md:flex items-center gap-6">
                                        <a class="{{ request()->routeIs('home') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant font-medium border-b-2 border-transparent' }} pb-1 font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
                                                href="{{ route('home') }}">Feed</a>
                                        <a class="text-on-surface-variant font-medium border-b-2 border-transparent pb-1 font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
                                                href="#">Authors</a>
                                        <a class="{{ request()->routeIs('posts.*') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant font-medium border-b-2 border-transparent' }} pb-1 font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
                                                href="{{ route('posts.index') }}">Dashboard</a>
                                        <a class="{{ request()->routeIs('categories.*') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant font-medium border-b-2 border-transparent' }} pb-1 font-ui-label text-ui-label hover:text-primary transition-colors duration-200"
                                                href="{{ route('categories.index') }}">Categories</a>
                                </nav>
                        </div>
                        <div class="flex items-center gap-4">
                                <div
                                        class="hidden lg:flex items-center bg-surface-container border border-outline-variant rounded-full px-4 py-1.5 gap-2">
                                        <span class="material-symbols-outlined text-secondary"
                                                data-icon="search">search</span>
                                        <input class="bg-transparent border-none focus:ring-0 text-ui-label font-ui-label w-48"
                                                placeholder="Search..." type="text" />
                                </div>
                                <div class="flex items-center gap-2">
                                        @php $unreadCount = Auth::check() ? Auth::user()->unreadNotifications()->count() : 0 @endphp
                                        <a href="{{ route('notifications.index') }}"
                                                class="relative p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all inline-flex items-center">
                                                <span class="material-symbols-outlined"
                                                        data-icon="notifications">notifications</span>
                                                <span data-unread-badge class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-error text-white text-[10px] font-bold rounded-full flex items-center justify-center {{ $unreadCount > 0 ? '' : 'hidden' }}">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                        </a>
                                        <button
                                                class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all">
                                                <span class="material-symbols-outlined"
                                                        data-icon="bookmark">bookmark</span>
                                        </button>
                                        <x-user-menu />
                                </div>
                        </div>
                </div>
        </header>
        <!-- Main Content Layout -->
        {{ $slot }}
        <!-- Footer -->
        <footer class="bg-surface border-t border-outline-variant">
                <div
                        class="w-full py-section-gap px-gutter max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex flex-col gap-2 items-center md:items-start">
                                <span
                                        class="font-headline-md text-headline-md text-on-surface">{{config('app.name')}}</span>
                                <p class="font-metadata text-metadata text-secondary">© 2026 {{config('app.name')}}. All
                                        rights reserved.</p>
                        </div>
                        <nav class="flex flex-wrap justify-center gap-8">
                                <a class="text-secondary font-metadata text-metadata hover:text-on-surface underline transition-all"
                                        href="#">About</a>
                                <a class="text-secondary font-metadata text-metadata hover:text-on-surface underline transition-all"
                                        href="#">Privacy</a>
                                <a class="text-secondary font-metadata text-metadata hover:text-on-surface underline transition-all"
                                        href="#">Terms</a>
                                <a class="text-secondary font-metadata text-metadata hover:text-on-surface underline transition-all"
                                        href="#">API</a>
                                <a class="text-secondary font-metadata text-metadata hover:text-on-surface underline transition-all"
                                        href="#">Help</a>
                        </nav>
                        <div class="flex gap-4">
                                <button
                                        class="p-2 text-secondary hover:text-primary transition-colors focus:outline-none ring-primary"><span
                                                class="material-symbols-outlined">alternate_email</span></button>
                                <button
                                        class="p-2 text-secondary hover:text-primary transition-colors focus:outline-none ring-primary"><span
                                                class="material-symbols-outlined">rss_feed</span></button>
                        </div>
                </div>
        </footer>
        @vite('resources/js/app.js')
</body>

</html>

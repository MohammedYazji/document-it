<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login - Ink &amp; Paper</title>
    @vite('resources/css/app.css')
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@400;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        body {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body class="font-body-md text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed">
    <!-- Top Navigation (Shell suppressed but branding maintained) -->
    <header class="bg-surface docked full-width top-0 border-b border-outline-variant">
        <div class="flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-16">
            <span class="font-display-lg-mobile text-display-lg-mobile font-bold text-on-surface">Ink &amp; Paper</span>
            <div class="hidden md:flex gap-6 items-center">
                <a class="font-ui-label text-ui-label text-on-surface-variant hover:text-primary transition-colors duration-200"
                    href="#">Help</a>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="min-h-[calc(100vh-128px)] flex items-center justify-center py-section-gap px-gutter">
        <div class="w-full max-w-[440px]">
            <!-- Login Card -->
            <div
                class="bg-surface-container-lowest border border-outline-variant p-8 md:p-10 rounded-lg shadow-[0_20px_30px_-10px_rgba(0,0,0,0.05)] transition-all">
                <div class="mb-8 text-center md:text-left">
                    <h1 class="font-headline-md text-headline-md text-on-surface mb-2">Welcome back</h1>
                    <p class="font-body-md text-secondary">Sign in to your editorial workspace.</p>
                </div>
                @if ($errors->any())
                    <div class="mb-4 bg-error-container p-4 rounded text-on-error-container text-sm">
                        <div class="font-bold mb-2">Whoops! Something went wrong.</div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label class="font-ui-label text-ui-label text-on-surface-variant block" for="email">Email
                            Address</label>
                        <input
                            class="w-full h-12 px-4 bg-surface-bright border border-outline-variant rounded focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all font-ui-label text-on-surface placeholder:text-outline"
                            id="email" name="email" value="{{ old('email') }}" placeholder="name@domain.com"
                            required autofocus type="email" />
                    </div>
                    <!-- Password Field -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="font-ui-label text-ui-label text-on-surface-variant"
                                for="password">Password</label>
                            <a class="font-ui-label text-ui-label text-primary hover:underline transition-all"
                                href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                        <input
                            class="w-full h-12 px-4 bg-surface-bright border border-outline-variant rounded focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all font-ui-label text-on-surface placeholder:text-outline"
                            id="password" name="password" placeholder="••••••••" required="" type="password" />
                    </div>
                    <!-- Remember Me -->
                    <div class="flex items-center gap-3">
                        <input
                            class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary transition-all"
                            id="remember" name="remember" type="checkbox" />
                        <label class="font-ui-label text-ui-label text-on-secondary-fixed-variant select-none"
                            for="remember">Remember me for 30 days</label>
                    </div>
                    <!-- Primary Action -->
                    <button
                        class="w-full h-12 bg-primary-container text-on-primary font-ui-button text-ui-button rounded hover:bg-primary active:scale-95 transition-all flex justify-center items-center gap-2"
                        type="submit">
                        Sign In
                    </button>
                </form>
                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-outline-variant"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="bg-surface-container-lowest px-4 font-metadata text-metadata text-outline uppercase tracking-widest">or
                            continue with</span>
                    </div>
                </div>
                <!-- Social Logins -->
                <div class="grid grid-cols-2 gap-4">
                    <button
                        class="h-12 border border-on-surface flex items-center justify-center gap-3 font-ui-label text-ui-label text-on-surface hover:bg-surface-container transition-all rounded">
                        <span class="material-symbols-outlined text-[20px]" data-icon="cloud">cloud</span>
                        Google
                    </button>
                    <button
                        class="h-12 border border-on-surface flex items-center justify-center gap-3 font-ui-label text-ui-label text-on-surface hover:bg-surface-container transition-all rounded">
                        <span class="material-symbols-outlined text-[20px]" data-icon="terminal">terminal</span>
                        Github
                    </button>
                </div>
                <!-- Footer Link -->
                <div class="mt-10 text-center">
                    <p class="font-ui-label text-ui-label text-on-surface-variant">
                        New to Ink &amp; Paper?
                        @if (Route::has('register'))
                            <a class="text-primary font-bold hover:underline transition-all ml-1"
                                href="{{ route('register') }}">Create an Account</a>
                        @endif
                    </p>
                </div>
            </div>
            <!-- Transactional Context Image -->
            <div class="mt-12 opacity-40 grayscale group-hover:grayscale-0 transition-all">
                <img alt="Inspiration"
                    class="w-full h-24 object-cover rounded-lg border border-outline-variant grayscale"
                    data-alt="A macro close-up of a high-quality fountain pen tip resting on textured ivory-colored paper. The scene is shot in a bright, minimalist studio with soft diffused lighting, emphasizing the sharp contrast between the dark ink and the clean white surface. The atmosphere is quiet and professional, reflecting a premium editorial and creative writing environment. Subtle shadows add depth to the minimal monochromatic palette."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCaZzKZpXNwoxBOGg9qTCZOzjVtZgaq3v5K8sIDlTkB84CPOVf_AboEgvK7uVkq_-xo579Nl8Lo_BtjUxPflCR4Vgbs6kRK6ky6zyEvGrEfWMFD3oPgLRwRAb-c4f8jO73qjl1LwUEEI32HZaEuxonXTXoetuE3qdUGsu4Ec9HO4UuTL2phazkyVjlixFHaaGQ94g5tBW6pagkXvkhyBeSbasPRz9MmVa4P2sa8aFZocu96y0agSrKIXhQjp8QNtmD-Yzbod-SeXTOE" />
            </div>
        </div>
    </main>
    <!-- Footer Component -->
    <footer class="bg-surface full-width border-t border-outline-variant">
        <div
            class="w-full py-section-gap px-gutter max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="font-headline-md text-headline-md text-on-surface">Ink &amp; Paper</span>
            <div class="flex gap-6">
                <a class="font-body-md text-secondary hover:text-on-surface underline transition-all"
                    href="#">About</a>
                <a class="font-body-md text-secondary hover:text-on-surface underline transition-all"
                    href="#">Privacy</a>
                <a class="font-body-md text-secondary hover:text-on-surface underline transition-all"
                    href="#">Terms</a>
                <a class="font-body-md text-secondary hover:text-on-surface underline transition-all"
                    href="#">API</a>
                <a class="font-body-md text-secondary hover:text-on-surface underline transition-all"
                    href="#">Help</a>
            </div>
            <p class="font-metadata text-metadata text-secondary">© 2024 Ink &amp; Paper Platform. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Forgot Password - Ink &amp; Paper</title>
@vite('resources/css/app.css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Source+Serif+4:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        body {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body-md selection:bg-primary-fixed selection:text-primary">
<!-- Top Navigation Bar (Suppressed items for Transactional Screen) -->
<header class="bg-surface border-b border-outline-variant w-full h-16 fixed top-0 z-50">
<div class="flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-full">
<div class="font-display-lg-mobile text-display-lg-mobile font-bold text-on-surface">Ink &amp; Paper</div>
<a class="font-ui-label text-ui-label text-on-surface-variant hover:text-primary transition-colors duration-200 flex items-center gap-2" href="/login">
<span class="material-symbols-outlined" data-icon="arrow_back">arrow_back</span>
                Back to Login
            </a>
</div>
</header>
<main class="min-h-screen flex items-center justify-center pt-16 px-margin-mobile">
<div class="w-full max-w-[440px] flex flex-col gap-8">
<!-- Branding/Icon Section -->
<div class="flex flex-col items-center text-center gap-4">
<div class="w-16 h-16 rounded-full bg-surface-container-lowest flex items-center justify-center border border-outline-variant shadow-sm">
<span class="material-symbols-outlined text-primary text-[32px]" data-icon="lock_reset">lock_reset</span>
</div>
<div class="space-y-2">
<h1 class="font-headline-md text-headline-md text-on-surface">Reset your password</h1>
<p class="font-body-md text-on-surface-variant max-w-[360px] mx-auto">
                        Enter the email address associated with your account and we'll send you a link to reset your password.
                    </p>
</div>
</div>
<!-- Form Section -->
<div class="bg-surface-container-lowest p-8 border border-outline-variant rounded-xl">
@if (session('status'))
    <div class="mb-6 bg-primary-container/20 text-primary px-4 py-3 rounded-lg border border-primary/20 text-sm font-medium">
        {{ session('status') }}
    </div>
@endif
@if ($errors->any())
    <div class="mb-6 bg-error-container/20 text-error px-4 py-3 rounded-lg border border-error/20 text-sm font-medium">
        {{ $errors->first() }}
    </div>
@endif
<form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
@csrf
<div class="flex flex-col gap-2">
<label class="font-ui-label text-ui-label text-on-surface-variant" for="email">Email Address</label>
<input class="w-full h-12 px-4 bg-surface border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all font-ui-label text-on-surface placeholder:text-secondary-fixed-dim" id="email" name="email" placeholder="name@company.com" required="" type="email"/>
</div>
<button class="w-full h-12 bg-primary-container hover:bg-primary text-on-primary font-ui-button text-ui-button rounded-lg transition-all active:scale-[0.98] active:opacity-90 shadow-sm" type="submit">
                        Send Reset Link
                    </button>
</form>
</div>
<!-- Supporting Illustration (Subtle) -->
<div class="relative w-full h-48 rounded-xl overflow-hidden grayscale opacity-40 hover:opacity-80 transition-opacity duration-700">
<img alt="Minimalist study space" class="w-full h-full object-cover" data-alt="A clean, minimalist workspace featuring a stack of high-quality cream-colored paper and a sleek black ink pen resting on top. The scene is shot from a high angle with soft, bright natural lighting coming from a side window, creating delicate shadows. The aesthetic is monochromatic and quiet, emphasizing the Paper and Ink theme of the platform. The overall mood is focused, serene, and professional." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBa4NDSej0z5gbXHGBYJI-znfvY5P2CQXiE3l4Y8BBTagXhBklDJANDqUqvZ6RV0ij63Z3KiOVcNReu0hHTvQVJZbdqeQbMmRQuJgZhJD_sbqA5t91oxufjBC-e6YitreIJIHMcqYlUdMuZV9LqaW6GQ2SXV5gRVjjEJPVN_Cb621vR71s-08ugKIUQPG81_N3BpyM_HTAmaYLGVvtw2VJd1GOe2Mum79WovoT-PHVyq9goKJEbb1MmOcZB28PmCU6E10nNQ05oc8KF"/>
</div>
<!-- Footer Link -->
<div class="text-center">
<a class="font-ui-label text-ui-label text-secondary hover:text-on-surface underline transition-all" href="/login">
                    I remember my password
                </a>
</div>
</div>
</main>
<!-- Footer (Using Shared Components Logic) -->
<footer class="w-full py-12 px-gutter max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-center gap-4 border-t border-outline-variant mt-24">
<div class="font-headline-md text-headline-md text-on-surface">Ink &amp; Paper</div>
<div class="flex gap-6">
<a class="font-metadata text-metadata text-secondary hover:text-on-surface underline transition-all" href="#">About</a>
<a class="font-metadata text-metadata text-secondary hover:text-on-surface underline transition-all" href="#">Privacy</a>
<a class="font-metadata text-metadata text-secondary hover:text-on-surface underline transition-all" href="#">Terms</a>
<a class="font-metadata text-metadata text-secondary hover:text-on-surface underline transition-all" href="#">Help</a>
</div>
<div class="font-metadata text-metadata text-secondary">
            © 2024 Ink &amp; Paper Platform. All rights reserved.
        </div>
</footer>
</body></html>

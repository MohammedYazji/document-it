<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - {{config('app.name')}}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-on-surface min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">&gt;&gt; {{config('app.name')}}</h1>
            <p class="text-sm text-on-surface-variant mt-1">$ sign in</p>
        </div>

        @if ($errors->any())
            <div class="p-3 bg-error/10 border border-error/30 rounded text-sm text-error">
                <span class="font-bold">!</span> {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-3 bg-error/10 border border-error/30 rounded text-sm text-error">
                <span class="font-bold">!</span> {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('google.redirect') }}" class="flex items-center justify-center gap-2 w-full bg-surface border border-outline-variant rounded py-2 text-sm text-on-surface hover:bg-surface-container transition-colors">
            <span>G</span> sign in with google
        </a>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-outline-variant"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-background px-3 text-xs text-on-surface-variant/50">or</span>
            </div>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ email</label>
                <input name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="user@domain.com" />
            </div>
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="text-xs text-on-surface-variant/50">$ password</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-primary hover:underline">forgot?</a>
                </div>
                <input name="password" type="password" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="***" />
            </div>
            <div class="flex items-center gap-2">
                <input name="remember" type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary" />
                <label class="text-xs text-on-surface-variant">remember me</label>
            </div>
            <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded text-sm hover:opacity-90 transition-opacity">
                $ sign in
            </button>
        </form>

        @if (Route::has('register'))
            <p class="text-center text-sm text-on-surface-variant">
                new here? <a href="{{ route('register') }}" class="text-primary hover:underline">$ create account</a>
            </p>
        @endif
    </div>
</body>
</html>

<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - {{config('app.name')}}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-on-surface min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">&gt;&gt; {{config('app.name')}}</h1>
            <p class="text-sm text-on-surface-variant mt-1">$ create account</p>
        </div>

        @if ($errors->any())
            <div class="p-3 bg-error/10 border border-error/30 rounded text-sm text-error">
                <span class="font-bold">!</span> {{ $errors->first() }}
            </div>
        @endif

        <a href="{{ route('google.redirect') }}" class="flex items-center justify-center gap-2 w-full bg-surface border border-outline-variant rounded py-2 text-sm text-on-surface hover:bg-surface-container transition-colors">
            <span>G</span> sign up with google
        </a>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-outline-variant"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-background px-3 text-xs text-on-surface-variant/50">or</span>
            </div>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ name</label>
                <input name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="John Doe" />
            </div>
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ email</label>
                <input name="email" type="email" value="{{ old('email') }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="user@domain.com" />
            </div>
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ password</label>
                <input name="password" type="password" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="***" />
            </div>
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ confirm password</label>
                <input name="password_confirmation" type="password" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="***" />
            </div>
            <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded text-sm hover:opacity-90 transition-opacity">
                $ register
            </button>
        </form>

        <p class="text-center text-sm text-on-surface-variant">
            already have an account? <a href="{{ route('login') }}" class="text-primary hover:underline">$ sign in</a>
        </p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - {{config('app.name')}}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-on-surface min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">&gt;&gt; {{config('app.name')}}</h1>
            <p class="text-sm text-on-surface-variant mt-1">$ new password</p>
        </div>

        @if ($errors->any())
            <div class="p-3 bg-error/10 border border-error/30 rounded text-sm text-error">
                <span class="font-bold">!</span> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ new password</label>
                <input name="password" type="password" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="***" />
            </div>
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ confirm</label>
                <input name="password_confirmation" type="password" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="***" />
            </div>
            <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded text-sm hover:opacity-90 transition-opacity">
                $ update password
            </button>
        </form>

        <p class="text-center text-sm text-on-surface-variant">
            <a href="/login" class="text-primary hover:underline">$ back to login</a>
        </p>
    </div>
</body>
</html>

<x-layout title="Create User">
    <main class="py-6 px-4 max-w-2xl mx-auto space-y-6">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-on-surface-variant hover:text-primary transition-colors">$ back</a>
            <h1 class="text-xl font-bold text-on-surface mt-2">Create User</h1>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" />
                @error('name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" />
                @error('email') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ username</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" />
                @error('username') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ password</label>
                <input type="password" name="password" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" />
                @error('password') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ type</label>
                <select name="type" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface">
                    <option value="user" {{ old('type') === 'user' ? 'selected' : '' }}>user</option>
                    <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>admin</option>
                    <option value="super-admin" {{ old('type') === 'super-admin' ? 'selected' : '' }}>super-admin</option>
                </select>
                @error('type') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-2">$ roles</label>
                <div class="space-y-2">
                    @foreach ($roles as $role)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-outline-variant bg-surface hover:border-primary cursor-pointer transition-colors">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                class="rounded border-outline-variant text-primary focus:ring-primary" />
                            <div>
                                <span class="text-sm font-bold text-on-surface">{{ $role->name }}</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach ($role->abilities as $ability)
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-primary/10 text-primary">{{ $ability }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('roles') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded text-sm hover:opacity-90 transition-opacity">
                    $ create user
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-on-surface-variant hover:text-on-surface transition-colors">$ cancel</a>
            </div>
        </form>
    </main>
</x-layout>

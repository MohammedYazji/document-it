<x-layout title="Edit User">
    <x-slot:style>
        <style>
            body { background-color: #f9f9f9; }
        </style>
    </x-slot:style>

    <main class="flex-grow w-full max-w-container-max mx-auto px-gutter py-12 pt-24">
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="text-primary hover:underline font-ui-label">&larr; Back to Users</a>
            <h1 class="font-display-lg text-[36px] text-on-background leading-tight mt-2">Edit User</h1>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="max-w-lg bg-surface-container-lowest border border-outline-variant rounded-2xl p-8">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="font-ui-label text-ui-label text-on-surface mb-1 block">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2 rounded-lg border border-outline-variant focus:outline-none focus:ring-2 focus:ring-primary">
                @error('name') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="font-ui-label text-ui-label text-on-surface mb-1 block">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2 rounded-lg border border-outline-variant focus:outline-none focus:ring-2 focus:ring-primary">
                @error('email') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="font-ui-label text-ui-label text-on-surface mb-1 block">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                       class="w-full px-4 py-2 rounded-lg border border-outline-variant focus:outline-none focus:ring-2 focus:ring-primary">
                @error('username') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="font-ui-label text-ui-label text-on-surface mb-1 block">Type</label>
                <select name="type" required
                        class="w-full px-4 py-2 rounded-lg border border-outline-variant focus:outline-none focus:ring-2 focus:ring-primary bg-white">
                    <option value="user" {{ old('type', $user->type) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('type', $user->type) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super-admin" {{ old('type', $user->type) === 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('type') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="font-ui-label text-ui-label text-on-surface mb-3 block">Roles</label>
                <div class="space-y-2">
                    @foreach ($roles as $role)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-outline-variant hover:bg-surface-container-low cursor-pointer">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                   {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary">
                            <div>
                                <span class="font-ui-label text-ui-label text-on-surface">{{ $role->name }}</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach ($role->abilities as $ability)
                                        <span class="text-[11px] px-2 py-0.5 rounded-full bg-primary-fixed text-primary font-medium">{{ $ability }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('roles') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-primary text-white px-6 py-3 rounded-full font-ui-button hover:opacity-90 transition-opacity">
                Update User
            </button>
        </form>
    </main>
</x-layout>

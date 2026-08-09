<x-layout title="Settings">
    <main class="py-6 px-4 max-w-lg mx-auto space-y-6">
        <div>
            <h1 class="text-xl font-bold text-on-surface">Settings</h1>
            <p class="text-sm text-on-surface-variant mt-1">$ update your profile</p>
        </div>

        @if (session('success'))
            <div class="p-3 bg-primary/10 border border-primary/30 rounded text-sm text-on-surface">
                <span class="text-primary">//</span> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-3 bg-error/10 border border-error/30 rounded text-sm text-error">
                <span class="font-bold">!</span> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Avatar --}}
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ avatar</label>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-lg bg-surface-container border border-outline-variant overflow-hidden shrink-0">
                        <img id="avatar-preview" alt="" class="w-full h-full object-cover" src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=58a6ff&background=0d1117&size=64' }}" />
                    </div>
                    <div class="flex-1">
                        <input type="file" name="avatar" accept="image/*" id="avatar-input"
                            class="w-full text-[10px] text-on-surface-variant file:mr-2 file:py-1 file:px-2 file:rounded file:border file:border-outline-variant file:text-[10px] file:bg-surface-container file:text-on-surface"
                            onchange="const f=this.files[0]; if(f){ const r=new FileReader(); r.onload=e=>{ document.getElementById('avatar-preview').src=e.target.result; }; r.readAsDataURL(f); }" />
                    </div>
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" />
            </div>

            {{-- Email --}}
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" />
            </div>

            {{-- Username --}}
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" />
            </div>

            {{-- Password --}}
            <div class="border-t border-outline-variant pt-4">
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ password <span class="text-on-surface-variant/30">(leave empty to keep current)</span></label>
                <input type="password" name="password"
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="••••••••" />
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ confirm password</label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="••••••••" />
            </div>

            {{-- Submit --}}
            <div class="pt-4 border-t border-outline-variant">
                <button type="submit" class="w-full bg-primary text-on-primary px-4 py-2 rounded text-sm hover:opacity-90 transition-opacity">
                    $ save changes
                </button>
            </div>
        </form>
    </main>
</x-layout>

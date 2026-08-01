<x-layout title="Users">
    <main class="py-6 px-4 max-w-5xl mx-auto space-y-6">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-on-surface">Users</h1>
                <p class="text-sm text-on-surface-variant mt-1">$ manage accounts</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="bg-primary text-on-primary px-4 py-2 rounded text-sm hover:opacity-90 transition-opacity shrink-0">
                $ new user
            </a>
        </div>

        @if (session('success'))
            <div class="p-3 bg-primary/10 border border-primary/30 rounded text-sm text-on-surface">
                <span class="text-primary">//</span> {{ session('success') }}
            </div>
        @endif

        <div class="space-y-1">
            @forelse ($users as $user)
                <div class="flex items-center gap-3 p-3 rounded-lg border border-outline-variant bg-surface hover:border-primary transition-colors group">
                    <div class="w-6 h-6 rounded bg-primary/10 flex items-center justify-center shrink-0">
                        <span class="text-primary text-xs">@</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-on-surface">{{ $user->name }}</p>
                        <p class="text-xs text-on-surface-variant/50">{{ $user->email }}</p>
                    </div>
                    <code class="text-xs text-on-surface-variant bg-surface-container px-2 py-0.5 rounded border border-outline-variant">{{ $user->username }}</code>
                    <span class="text-xs px-1.5 py-0.5 rounded bg-primary/10 text-primary shrink-0">{{ $user->type }}</span>
                    <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="px-2 py-1 text-xs text-on-surface-variant hover:text-primary rounded transition-colors">edit</a>
                        <button type="button" onclick="openDeleteModal('{{ Str::slug($user->name) }}')" class="px-2 py-1 text-xs text-error hover:text-error rounded transition-colors">del</button>
                    </div>
                </div>

                <x-delete-modal :name="$user->name" type="user" />

                <form id="delete-form-{{ Str::slug($user->name) }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            @empty
                <div class="py-12 text-center text-sm text-on-surface-variant">No users found</div>
            @endforelse
        </div>

        {{ $users->links() }}
    </main>
</x-layout>

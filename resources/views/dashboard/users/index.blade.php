<x-layout title="Manage Users">
    <x-slot:style>
        <style>
            body { background-color: #f9f9f9; }
        </style>
    </x-slot:style>

    <main class="flex-grow w-full max-w-container-max mx-auto px-gutter py-12 pt-24">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <p class="text-metadata font-metadata text-secondary uppercase tracking-widest mb-1">Dashboard</p>
                <h1 class="font-display-lg text-[36px] text-on-background leading-tight">Manage Users</h1>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all shadow-sm whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">add</span>
                New User
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="font-ui-label text-ui-label text-green-800">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
            <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 border-b border-outline-variant bg-surface-container-low">
                <div class="col-span-3 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Name</div>
                <div class="col-span-3 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Email</div>
                <div class="col-span-2 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Username</div>
                <div class="col-span-2 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Type / Roles</div>
                <div class="col-span-2 font-ui-label text-ui-label text-secondary uppercase tracking-wider text-right">Actions</div>
            </div>

            @forelse ($users as $user)
                <div class="grid grid-cols-12 gap-4 px-6 py-4 border-b border-outline-variant last:border-0 items-center hover:bg-surface-container-low transition-colors">
                    <div class="col-span-12 md:col-span-3 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary text-[16px]">person</span>
                        </div>
                        <p class="font-ui-label text-ui-label font-semibold text-on-surface">{{ $user->name }}</p>
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <p class="font-ui-label text-ui-label text-on-surface-variant">{{ $user->email }}</p>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <code class="text-metadata font-metadata bg-surface-container px-2 py-1 rounded text-secondary">{{ $user->username }}</code>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-primary font-metadata font-semibold text-[12px]">
                            {{ $user->type }}
                        </span>
                        @if ($user->roles->isNotEmpty())
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach ($user->roles as $role)
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-surface-container text-secondary font-medium">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-span-12 md:col-span-2 flex justify-end items-center gap-1">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="p-2 rounded-lg text-on-surface-variant hover:bg-primary-fixed hover:text-primary transition-all" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete user \'{{ addslashes($user->name) }}\'?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-error hover:bg-error-container transition-all" title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 px-8">
                    <p class="font-ui-label text-ui-label text-secondary">No users found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </main>
</x-layout>

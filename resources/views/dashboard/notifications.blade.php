<x-layout title="Notifications">
    <main class="py-6 px-4 max-w-2xl mx-auto space-y-4">
        <h1 class="text-xl font-bold text-on-surface">Notifications</h1>

        <div class="space-y-1">
            @forelse ($notifications as $notification)
                @php $data = $notification->data @endphp
                <div class="p-4 rounded-lg border {{ $notification->read_at ? 'border-outline-variant bg-surface' : 'border-primary/30 bg-surface' }} font-mono text-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-green-400 font-bold">200</span>
                        <span class="text-on-surface-variant/30">|</span>
                        <span class="text-green-400/80 text-xs">{{ $notification->created_at->diffForHumans() }}</span>
                        @unless ($notification->read_at)
                            <span class="text-primary text-xs">[new]</span>
                        @endunless
                    </div>
                    <div class="text-on-surface-variant/50">{</div>
                    <div class="pl-4 text-on-surface">
                        "body": "{{ addslashes($data['body'] ?? $data['title'] ?? '') }}"
                    </div>
                    @if(isset($data['link']))
                    <div class="pl-4 text-on-surface">
                        "link": "{{ $data['link'] }}"
                    </div>
                    @endif
                    <div class="text-on-surface-variant/50">}</div>
                </div>
            @empty
                <div class="p-4 rounded-lg border border-yellow-500/30 bg-surface font-mono text-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-yellow-400 font-bold">WARN</span>
                        <span class="text-on-surface-variant/30">|</span>
                        <span class="text-yellow-400/80 text-xs">exit code 1</span>
                    </div>
                    <div class="text-on-surface-variant/50">{</div>
                    <div class="pl-4 text-yellow-400">
                        "error": "no notifications found"
                    </div>
                    <div class="pl-4 text-on-surface-variant">
                        "inbox": "empty"
                    </div>
                    <div class="text-on-surface-variant/50">}</div>
                </div>
            @endforelse
        </div>

        {{ $notifications->links() }}
    </main>
</x-layout>

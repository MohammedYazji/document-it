<x-layout title="Notifications">
    <x-slot:style>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 200, 'GRAD' 0, 'opsz' 24;
                vertical-align: middle;
            }

            body {
                background-color: #f9f9f9;
                color: #1a1c1c;
            }
        </style>
    </x-slot:style>

    <main class="flex-grow w-full max-w-container-max mx-auto px-gutter py-12 pt-24">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="font-display-lg text-display-lg text-on-background mb-2">Notifications</h1>
                    <p class="text-on-surface-variant font-ui-label text-ui-label">Stay updated with your latest activity.</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($notifications as $notification)
                    @php $data = $notification->data @endphp
                    <div
                        class="bg-surface-container-lowest rounded-xl border border-outline-variant p-5 {{ $notification->read_at ? '' : 'ring-1 ring-primary/20 bg-primary-fixed/5' }}">
                        <div class="flex items-start gap-4">
                            @if (isset($data['meta']['follower_avatar']))
                                <img class="w-10 h-10 rounded-full object-cover shrink-0"
                                    src="{{ $data['meta']['follower_avatar'] }}" alt="">
                            @else
                                <div
                                    class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant shrink-0 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-secondary">person</span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <a href="{{ $data['link'] ?? '#' }}" class="hover:underline">
                                    <p class="font-ui-label text-ui-label text-on-surface">{{ $data['body'] ?? $data['title'] ?? '' }}</p>
                                </a>
                                <p class="font-metadata text-metadata text-secondary mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    @if ($notification->read_at)
                                        <form method="POST" action="{{ route('notifications.unread', $notification->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="font-metadata text-metadata text-secondary hover:text-primary underline transition-colors">Mark unread</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="font-metadata text-metadata text-secondary hover:text-primary underline transition-colors">Mark read</button>
                                        </form>
                                    @endif
                                    <span class="text-outline">·</span>
                                    <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-metadata text-metadata text-secondary hover:text-error underline transition-colors">Delete</button>
                                    </form>
                                </div>
                            </div>
                            @unless ($notification->read_at)
                                <span class="w-2 h-2 rounded-full bg-primary shrink-0 mt-2"></span>
                            @endunless
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 border border-outline-variant rounded-xl bg-surface-container-lowest">
                        <span class="material-symbols-outlined text-4xl text-outline">notifications_off</span>
                        <p class="font-ui-label text-ui-label text-secondary mt-4">No notifications yet</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        </div>
    </main>
</x-layout>

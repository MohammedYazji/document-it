@props(['icon', 'title', 'message'])

<div class="text-center py-20 px-8 flex flex-col items-center gap-3">
    <div class="w-14 h-14 rounded-full bg-surface-container flex items-center justify-center">
        <span class="material-symbols-outlined text-[28px] text-secondary">{{ $icon }}</span>
    </div>
    <h3 class="font-headline-md text-[20px] text-on-surface">{!! $title !!}</h3>
    <p class="font-ui-label text-ui-label text-secondary max-w-sm">{{ $message }}</p>
    {{ $slot }}
</div>

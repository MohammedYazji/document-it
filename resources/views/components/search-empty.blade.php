@props(['icon', 'title', 'message'])

<div class="text-center py-12">
    <p class="text-sm text-on-surface-variant mb-2">{{ $title }}</p>
    <p class="text-xs text-on-surface-variant/50">{{ $message }}</p>
    {{ $slot }}
</div>

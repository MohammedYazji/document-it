@props(['href', 'active' => false, 'count' => null])

<a href="{{ $href }}" 
   class="pb-4 text-ui-label whitespace-nowrap transition-all duration-200 {{ $active ? 'font-bold border-b-2 border-primary text-primary' : 'font-medium text-on-surface-variant hover:text-primary' }}">
    {{ $slot }}
    @if($count !== null)
        <span class="ml-1 opacity-80">({{ $count }})</span>
    @endif
</a>

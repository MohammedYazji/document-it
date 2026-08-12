@props(['href', 'active' => false, 'count' => null])

<a href="{{ $href }}" 
   class="whitespace-nowrap transition-colors pb-2 border-b-2 {{ $active ? 'font-bold border-primary text-primary' : 'border-transparent text-on-surface-variant hover:text-on-surface' }}">
    $ {{ $slot }}
    @if($count !== null)
        <span class="opacity-50">({{ $count }})</span>
    @endif
</a>

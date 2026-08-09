@props(['post'])

<a href="{{ route('post.show', $post->slug) }}" class="block group">
  <article class="p-4 border border-outline-variant rounded-lg bg-surface hover:border-primary transition-all">
    {{-- Top meta row --}}
    <div class="flex items-center gap-2 text-xs text-on-surface-variant/60 mb-2">
      <span class="text-primary font-bold">$</span>
      <span class="text-primary">{{ $post->category->name }}</span>
      <span class="text-on-surface-variant/30">|</span>
      <span>{{ $post->publish_time->format('M d, Y') }}</span>
      <span class="text-on-surface-variant/30">|</span>
      <span>{{ $post->views }} views</span>
    </div>

    {{-- Title --}}
    <h3 class="text-on-surface font-bold text-base mb-2 group-hover:text-primary transition-colors">{{ $post->title }}</h3>

    {{-- Excerpt as code block --}}
    @if($post->excerpt)
      <div class="bg-surface-container border border-outline-variant rounded p-3 mb-3">
        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-2" style="font-family: 'Courier New', Courier, monospace;">
          <span class="text-on-surface-variant/30">//</span> {{ $post->excerpt }}
        </p>
      </div>
    @endif

    {{-- Footer --}}
    <div class="flex items-center justify-between text-xs relative">
      <a href="{{ route('users.profile', $post->user->username) }}" class="flex absolute items-center gap-2 text-on-surface-variant/60 hover:text-primary transition-colors" onclick="event.stopPropagation()">
        <span class="text-primary/60">></span>
        <span>{{ $post->user->name }}</span>
      </a>
      <div class="flex items-center gap-3 text-on-surface-variant/40">
        <span>{{ $post->read_time }}min</span>
        <span class="text-primary/40">-></span>
      </div>
    </div>
  </article>
</a>

@props(['post'])

<a href="{{ route('post.show', $post->slug) }}" class="block group">
  <article class="flex gap-4 p-4 border border-outline-variant rounded-lg bg-surface hover:border-primary transition-colors">
    <img alt="" class="w-24 h-24 rounded object-cover opacity-80 group-hover:opacity-100 transition-opacity shrink-0" src="{{ $post->thumbnail_url }}" />
    <div class="flex flex-col justify-between min-w-0">
      <div class="space-y-1">
        <div class="flex items-center gap-2 text-xs text-on-surface-variant">
          <span class="text-primary">{{ $post->category->name }}</span>
          <span class="text-on-surface-variant/30">|</span>
          <span>{{ $post->publish_time->format('M d') }}</span>
        </div>
        <h3 class="text-on-surface font-bold text-sm group-hover:text-primary transition-colors line-clamp-2">{{ $post->title }}</h3>
      </div>
      <div class="flex items-center justify-between">
        <span class="text-xs text-on-surface-variant/60">{{ $post->user->name }}</span>
        <span class="text-xs text-on-surface-variant/40">{{ $post->views }}v</span>
      </div>
    </div>
  </article>
</a>

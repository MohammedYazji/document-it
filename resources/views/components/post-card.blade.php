@props(['post'])

<article class="flex flex-col md:flex-row gap-8 group">
  <a href="{{ route('post.show', $post->slug) }}" class="w-full md:w-1/3 aspect-video md:aspect-square overflow-hidden rounded-lg border border-outline-variant block">
    <img alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
      src="{{ $post->thumbnail_url }}" />
  </a>
  <div class="w-full md:w-2/3 space-y-3">
    <div class="flex items-center gap-2 font-metadata text-metadata text-secondary">
      <span class="text-primary font-bold">{{ $post->category->name }}</span>
      <span>•</span>
      <span>{{ $post->publish_time->format('M d, Y') }}</span>
      <span>•</span>
      <span class="flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">visibility</span>
        {{ $post->views }}
      </span>
    </div>
    <a href="{{ route('post.show', $post->slug) }}">
      <h3
        class="font-headline-md text-[24px] leading-snug text-on-surface group-hover:text-primary transition-colors">
        {{ $post->title }}</h3>
    </a>
    <p class="text-on-surface-variant font-body-md text-body-md line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
    <div class="flex items-center gap-3 pt-2">
      <p class="font-ui-label text-ui-label text-on-surface font-medium">{{ $post->user->name }}</p>
      <span class="text-secondary text-metadata">•</span>
      <span class="text-secondary font-metadata text-metadata">Author</span>
      <span class="ml-auto">
        <x-post-bookmark :post="$post" />
      </span>
    </div>
  </div>
</article>

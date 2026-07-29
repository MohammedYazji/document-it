<x-layout title="Document It">
  <x-slot:style>
    <style>
    </style>
  </x-slot:style>

  <main class="py-6 px-4 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-6">

    <!-- Left: Tags -->
    <aside class="hidden md:block md:col-span-2">
      <div class="sticky top-16">
        <p class="text-xs text-on-surface-variant/50 uppercase tracking-widest mb-2">tags</p>
        <div class="flex flex-wrap gap-1.5">
          <a class="px-2 py-1 text-xs bg-surface border border-outline-variant rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors" href="#">#dev</a>
          <a class="px-2 py-1 text-xs bg-surface border border-outline-variant rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors" href="#">#tutorial</a>
          <a class="px-2 py-1 text-xs bg-surface border border-outline-variant rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors" href="#">#code</a>
        </div>
      </div>
    </aside>

    <!-- Center: Feed -->
    <section class="md:col-span-7 space-y-6">
      @if($posts->isNotEmpty())
        @php
          $showFeatured = $posts->onFirstPage();
          $displayPosts = $showFeatured ? $posts->skip(1) : $posts;
        @endphp

        @if($showFeatured)
          @php $featuredPost = $posts->first(); @endphp
          <a href="{{ route('post.show', $featuredPost->slug) }}" class="block group">
            <article class="border border-outline-variant rounded-lg overflow-hidden bg-surface hover:border-primary transition-colors">
              <img alt="" class="w-full aspect-video object-cover opacity-80 group-hover:opacity-100 transition-opacity" src="{{ $featuredPost->thumbnail_url }}" />
              <div class="p-5 space-y-2">
                <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                  <span class="text-primary font-bold">$ featured</span>
                  <span class="text-on-surface-variant/30">|</span>
                  <span>{{ $featuredPost->publish_time->format('M d, Y') }}</span>
                  <span class="text-on-surface-variant/30">|</span>
                  <span>{{ $featuredPost->category->name }}</span>
                </div>
                <h2 class="text-on-surface text-lg font-bold group-hover:text-primary transition-colors">{{ $featuredPost->title }}</h2>
                <p class="text-sm text-on-surface-variant line-clamp-2">{{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 120) }}</p>
                <div class="flex items-center justify-between pt-2 border-t border-outline-variant">
                  <span class="text-xs text-on-surface-variant">{{ $featuredPost->user->name }}</span>
                  <x-post-bookmark :post="$featuredPost" />
                </div>
              </div>
            </article>
          </a>
        @endif

        @foreach($displayPosts as $post)
          <x-post-card :post="$post" />
        @endforeach

        <div class="pt-4">{{ $posts->links() }}</div>
      @else
        <div class="py-16 text-center border border-outline-variant rounded-lg bg-surface">
          <p class="text-on-surface-variant"><span class="text-error">!</span> No posts found</p>
        </div>
      @endif
    </section>

    <!-- Right: Trending -->
    <aside class="hidden lg:block lg:col-span-3">
      <div class="sticky top-16 space-y-6">
        <x-trending />
      </div>
    </aside>
  </main>
</x-layout>

<x-layout title="Document It">

  <x-slot:style>
    <style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
      }

      body {
        background-color: #f9f9f9;
        color: #1a1c1c;
      }
    </style>
  </x-slot:style>

  <main class="pt-24 pb-section-gap max-w-container-max mx-auto px-gutter grid grid-cols-1 md:grid-cols-12 gap-8">
  <!-- Left Sidebar: Navigation & Tags -->
  <aside class="hidden md:block md:col-span-2 space-y-8">
    <div class="space-y-4">
      <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">Discover</h3>
      <ul class="space-y-2">
        <li><a class="flex items-center gap-3 text-primary font-bold font-ui-label text-ui-label py-1" href="#"><span
              class="material-symbols-outlined" data-weight="fill"
              style="font-variation-settings: 'FILL' 1;">explore</span>Explore</a></li>
        <li><a
            class="flex items-center gap-3 text-on-surface-variant hover:text-primary transition-colors font-ui-label text-ui-label py-1"
            href="#"><span class="material-symbols-outlined">trending_up</span>Popular</a></li>
        <li><a
            class="flex items-center gap-3 text-on-surface-variant hover:text-primary transition-colors font-ui-label text-ui-label py-1"
            href="#"><span class="material-symbols-outlined">history</span>Recent</a></li>
      </ul>
    </div>
    <div class="space-y-4">
      <h3 class="font-ui-label text-ui-label uppercase tracking-widest text-secondary font-bold">Your Tags</h3>
      <div class="flex flex-wrap gap-2">
        <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
          href="#">#Development</a>
        <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
          href="#">#DesignSystems</a>
        <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
          href="#">#Minimalism</a>
        <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
          href="#">#Typography</a>
        <a class="px-3 py-1 bg-surface-container border border-outline-variant rounded-full font-metadata text-metadata hover:bg-outline-variant transition-colors"
          href="#">#Future</a>
      </div>
    </div>
  </aside>
  <!-- Center Feed -->
  <section class="col-span-1 md:col-span-7 space-y-12">
    @if($posts->isNotEmpty())
    @php
        $showFeatured = $posts->onFirstPage();
        $displayPosts = $showFeatured ? $posts->skip(1) : $posts;
    @endphp

    @if($showFeatured)
    @php $featuredPost = $posts->first(); @endphp
    <!-- Featured Article (Bento Style) -->
    <article
      class="group border border-outline-variant rounded-xl overflow-hidden bg-white hover:border-primary transition-colors duration-300">
      <a href="{{ route('post.show', $featuredPost->slug) }}" class="block aspect-[16/9] overflow-hidden">
        <img alt="{{ $featuredPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
          src="{{ $featuredPost->thumbnail_url }}" />
      </a>
      <div class="p-8 space-y-4">
        <div class="flex items-center gap-3 font-metadata text-metadata text-secondary">
          <span
            class="bg-primary-container text-on-primary px-2 py-0.5 rounded font-bold uppercase tracking-wider">Featured</span>
          <span>•</span>
          <span>{{ $featuredPost->publish_time->format('M d, Y') }}</span>
          <span>•</span>
          <span>{{ $featuredPost->category->name }}</span>
          <span>•</span>
          <span class="flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">visibility</span>
            {{ $featuredPost->views }}
          </span>
        </div>
        <a href="{{ route('post.show', $featuredPost->slug) }}">
            <h2
              class="font-headline-md text-headline-md text-on-surface leading-tight group-hover:text-primary transition-colors">
              {{ $featuredPost->title }}</h2>
        </a>
        <p class="text-on-surface-variant font-body-md text-body-md line-clamp-3">{{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 150) }}</p>
        <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant overflow-hidden">
              <img alt="{{ $featuredPost->user->name }}" class="w-full h-full object-cover"
                src="https://ui-avatars.com/api/?name={{ urlencode($featuredPost->user->name) }}&color=7F9CF5&background=EBF4FF" />
            </div>
            <div>
              <p class="font-ui-label text-ui-label font-bold text-on-surface">{{ $featuredPost->user->name }}</p>
              <p class="font-metadata text-metadata text-secondary">Author</p>
            </div>
          </div>
          <x-post-bookmark :post="$featuredPost" />
        </div>
      </div>
    </article>
    @endif

    <!-- Grid of Regular Articles -->
    <div class="grid grid-cols-1 gap-12">
      @foreach($displayPosts as $post)
      <x-post-card :post="$post" />
      @endforeach
    </div>
    <div class="pt-12">
      {{ $posts->links() }}
    </div>
    @else
    <div class="p-12 text-center border border-outline-variant rounded-xl bg-white">
        <h2 class="font-headline-md text-headline-md text-on-surface mb-4">No posts found</h2>
        <p class="text-on-surface-variant font-body-md">Check back later for new content!</p>
    </div>
    @endif
  </section>
  <!-- Right Sidebar: Trending & Who to Follow -->
  <aside class="hidden lg:block lg:col-span-3 space-y-12">
    <!-- Trending Section -->
    <x-trending />
    <!-- Who to Follow -->
    <x-recommended-authors title="Follow Authors" />
    <!-- Newsletter Sign Up -->
    <x-widgets.newsletter title="Newsletter">
      <p>Enter Your Email</p>
      <x-slot:helper>
        <p class="text-xs text-white">we care about your privacy unsubscribe anytime.</p>
      </x-slot:helper>
    </x-widgets.newsletter>
  </aside>
  </main>
</x-layout>

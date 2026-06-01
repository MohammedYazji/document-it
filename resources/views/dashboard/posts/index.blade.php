<x-layout title="Content Management">
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
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="font-display-lg text-display-lg text-on-background mb-2">Content Management</h1>
                <p class="text-on-surface-variant max-w-lg font-ui-label text-ui-label">Manage your intellectual output,
                    track performance, and schedule your upcoming editorial pieces.</p>
            </div>
            <a href="{{ route('posts.create') }}"
                class="bg-primary-container text-on-primary px-6 py-3 rounded-lg font-ui-button text-ui-button flex items-center gap-2 hover:opacity-90 active:scale-95 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]" data-icon="edit_square">edit_square</span>
                Create Post
            </a>
        </div>

        <!-- Dashboard Layout Grid -->
        <div class="grid grid-cols-12 gap-8">
            <!-- Sidebar / Stats (Bento Style) -->
            <aside class="col-span-12 lg:col-span-3 space-y-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant">
                    <span class="text-metadata font-metadata uppercase tracking-wider text-outline block mb-4">Total
                        Reach</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-headline-md font-headline-md">124.8k</span>
                        <span class="text-primary text-metadata font-bold">+12%</span>
                    </div>
                    <div class="mt-4 h-1 bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-primary w-3/4"></div>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant">
                    <span class="text-metadata font-metadata uppercase tracking-wider text-outline block mb-4">Active
                        Readers</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-headline-md font-headline-md">3,402</span>
                        <span class="text-primary text-metadata font-bold">Live</span>
                    </div>
                    <div class="mt-4 flex -space-x-2">
                        <img alt="Reader" class="h-8 w-8 rounded-full border-2 border-surface"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0VML3zUOfHvHKKGgB2fxPpyQcSC9dDq9j0F3O-7KH_-bJKLZNCU3pwl4DqzYrk4a9mDsbUjTTeGQn1-l7FjNNMq1fsTUXkKscVzA1EsyIyOQp4-zEo_R0qq4xuYna2CersNSNoMxRIG0w7MRpebhs_KgIWf9q32VIZN7GLS1K0m1tFxvwatR_gvRlf1TMFdZcSAZWPL2xMDJxu8K84-ayBmsIDrZ6b8fEqSHFoCKU4oAv8lcw89UGku8au7BjnTypsdLs5Y3VCeg-" />
                        <img alt="Reader" class="h-8 w-8 rounded-full border-2 border-surface"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBc3-HbWxqddsKbBQvRl9SvJVRGmlwiqFh1d-rJkyNdjwPkwMIDOjvHteSALjCg2r0gzl_5Z2Ly69CcdlgoOBkeOcRjQC7HCYkYc5WliviBJPQ8gMquCvlPGhm5UN8YPEinqbPSAiemK7PoUOscV22Lkq_dqVVUOwVCWxKSgLqY9xHOXWU2McIZ7HDKGMMBa7W4vxUqx1ghu5VHGHBH3KQdx9hyR8TAtGr30ZqCrwoioyW3M_gsVMu6Rf0gCPJHZVdwvRk-ydzKesNu" />
                        <div
                            class="h-8 w-8 rounded-full border-2 border-surface bg-primary-fixed flex items-center justify-center text-[10px] font-bold text-on-primary-fixed">
                            +42</div>
                    </div>
                </div>
                <div class="bg-on-background text-inverse-on-surface p-6 rounded-xl border border-outline">
                    <h3 class="font-headline-md text-[20px] mb-2">Pro Tip</h3>
                    <p class="text-metadata font-metadata opacity-80 leading-relaxed">Articles published on Tuesdays at
                        9:00 AM receive 40% more engagement in the 'Paper &amp; Ink' ecosystem.</p>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="col-span-12 lg:col-span-9 space-y-6">
                <!-- Tabs & Search Filter -->
                <div
                    class="flex flex-col md:flex-row md:items-center justify-between border-b border-outline-variant gap-4">
                    <div class="flex gap-8 overflow-x-auto no-scrollbar">
                        <x-tab :href="route('posts.index', ['status' => 'all'])" :active="$status === 'all'"
                            :count="$posts_all->count()">
                            All
                        </x-tab>
                        <x-tab :href="route('posts.index', ['status' => 'published'])" :active="$status === 'published'"
                            :count="$posts_all->where('status', 'published')->count()">
                            Published
                        </x-tab>
                        <x-tab :href="route('posts.index', ['status' => 'draft'])" :active="$status === 'draft'"
                            :count="$posts_all->where('status', 'draft')->count()">
                            Drafts
                        </x-tab>
                        <x-tab :href="route('posts.index', ['status' => 'scheduled'])" :active="$status === 'scheduled'"
                            :count="$posts_all->where('status', 'scheduled')->count()">
                            Scheduled
                        </x-tab>
                        <x-tab :href="route('posts.index', ['status' => 'archived'])" :active="$status === 'archived'"
                            :count="$posts_all->where('status', 'archived')->count()">
                            Archived
                        </x-tab>
                    </div>
                    <div class="flex items-center gap-2 pb-2">
                        <button
                            class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
                            <span class="material-symbols-outlined" data-icon="filter_list">filter_list</span>
                        </button>
                        <button
                            class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
                            <span class="material-symbols-outlined" data-icon="sort">sort</span>
                        </button>
                    </div>
                </div>
                <!-- Bulk Actions Bar (Sticky-ish) -->
                <div
                    class="bg-surface-container-low px-4 py-3 rounded-lg flex items-center justify-between border border-outline-variant">
                    <div class="flex items-center gap-4">
                        <input class="w-4 h-4 rounded border-outline text-primary focus:ring-primary" type="checkbox" />
                        <span class="text-metadata font-ui-label font-medium text-on-surface-variant">0 posts
                            selected</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button
                            class="text-metadata font-ui-label font-semibold text-secondary hover:text-on-surface transition-all">Unpublish</button>
                        <span class="w-px h-4 bg-outline-variant"></span>
                        <button
                            class="text-metadata font-ui-label font-semibold text-error hover:text-on-error-container transition-all">Delete</button>
                    </div>
                </div>

                <!-- Post Table/List -->
                <div class="space-y-4">
                    @forelse ($posts as $post)
                        <div
                            class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant hover:border-primary transition-all group">
                            <div class="flex items-start gap-4">
                                <input class="mt-2 w-4 h-4 rounded border-outline text-primary focus:ring-primary"
                                    type="checkbox" />
                                <div class="flex-grow grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                    <div class="md:col-span-6">
                                        <span class="text-metadata font-metadata text-primary mb-1 block">{{ $post->category->name }} •
                                            {{ ceil(str_word_count($post->content) / 200) }} min read</span>
                                        <a href="{{ route('posts.show', $post->id) }}">
                                            <h3
                                                class="font-headline-md text-[20px] leading-snug group-hover:text-primary transition-colors">
                                                {{ $post->title }}
                                            </h3>
                                        </a>
                                        <p class="text-metadata font-metadata text-on-surface-variant mt-1">Published on
                                            {{ $post->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="md:col-span-2 flex flex-col">
                                        <span class="text-metadata font-metadata text-outline">Engagement</span>
                                        <div class="flex items-center gap-4 mt-1">
                                            <div class="flex items-center gap-1 text-ui-label font-medium">
                                                <span class="material-symbols-outlined text-[18px]"
                                                    data-icon="visibility">visibility</span> {{ $post->views ?? 0 }}
                                            </div>
                                            <div class="flex items-center gap-1 text-ui-label font-medium">
                                                <span class="material-symbols-outlined text-[18px]"
                                                    data-icon="chat_bubble">chat_bubble</span> {{ $post->comments_count }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        @if($post->status === 'published')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-700 text-[12px] font-bold border border-green-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span> Published
                                            </span>
                                        @elseif($post->status === 'draft')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[12px] font-bold border border-yellow-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-yellow-600"></span> Draft
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-50 text-gray-700 text-[12px] font-bold border border-gray-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-gray-600"></span> Archived
                                            </span>
                                        @endif
                                    </div>
                                    <div
                                        class="md:col-span-2 flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="p-2 text-on-surface-variant hover:bg-surface-container hover:text-primary rounded-lg transition-all"
                                            title="Edit">
                                            <span class="material-symbols-outlined" data-icon="edit">edit</span>
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-error hover:bg-surface-container rounded-lg transition-all"
                                                title="Delete">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-white rounded-xl border border-outline-variant border-dashed p-8">
                            <span class="material-symbols-outlined text-[48px] text-secondary mb-4">article</span>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">No posts yet</h3>
                            <p class="font-body-md text-body-md text-secondary mb-6">Start your writing journey by creating
                                your first post.</p>
                            <a href="{{ route('posts.create') }}"
                                class="bg-primary text-white px-6 py-3 rounded-full font-ui-label hover:opacity-90 transition-opacity inline-block">
                                Write a Story
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($posts->isNotEmpty())
                    <div class="flex items-center justify-between pt-8">
                        <span class="text-metadata font-metadata text-on-surface-variant">Showing 1 to {{ $posts->count() }}
                            of {{ $posts->count() }} posts</span>
                        <div class="flex gap-2">
                            <button
                                class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low disabled:opacity-30"
                                disabled="">
                                <span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
                            </button>
                            <button
                                class="h-10 w-10 border border-primary bg-primary text-on-primary rounded-lg font-ui-label">1</button>
                            <button
                                class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low disabled:opacity-30"
                                disabled="">
                                <span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-layout>

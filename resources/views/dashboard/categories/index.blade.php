<x-layout title="Manage Categories">
    <x-slot:style>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 200, 'GRAD' 0, 'opsz' 24;
                vertical-align: middle;
            }
            body { background-color: #f9f9f9; color: #1a1c1c; }
            .category-row:hover .row-actions { opacity: 1; }
            .row-actions { opacity: 0; transition: opacity .2s; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
            .fade-in { animation: fadeIn .3s ease both; }
        </style>
    </x-slot:style>

    <main class="flex-grow w-full max-w-container-max mx-auto px-gutter py-12 pt-24">

        {{-- ── Header ── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <p class="text-metadata font-metadata text-secondary uppercase tracking-widest mb-1">Dashboard</p>
                <h1 class="font-display-lg text-[36px] text-on-background leading-tight">Manage Categories</h1>
                <p class="text-on-surface-variant font-ui-label text-ui-label mt-1 max-w-lg">
                    Organise your content with categories. Nest sub-categories under a parent for a clean hierarchy.
                </p>
            </div>
            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full font-ui-button text-ui-button hover:opacity-90 active:scale-95 transition-all shadow-sm whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">add</span>
                New Category
            </a>
        </div>

        {{-- ── Flash messages ── --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 fade-in">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="font-ui-label text-ui-label text-green-800">{{ session('success') }}</span>
            </div>
        @endif

        {{-- ── Stats row ── --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            @php
                $total      = $categories->count();
                $topLevel   = $categories->whereNull('parent_id')->count();
                $withPosts  = $categories->filter(fn($c) => $c->posts_count > 0 || $c->posts->count() > 0)->count();
                $nested     = $categories->whereNotNull('parent_id')->count();
            @endphp
            @foreach ([
                ['label' => 'Total',       'value' => $total,     'icon' => 'category'],
                ['label' => 'Top-level',   'value' => $topLevel,  'icon' => 'folder'],
                ['label' => 'Sub-cats',    'value' => $nested,    'icon' => 'account_tree'],
                ['label' => 'With Posts',  'value' => $withPosts, 'icon' => 'article'],
            ] as $stat)
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary text-[20px]">{{ $stat['icon'] }}</span>
                    </div>
                    <div>
                        <p class="font-ui-label text-ui-label text-secondary">{{ $stat['label'] }}</p>
                        <p class="font-headline-md text-[24px] font-semibold text-on-surface">{{ $stat['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Category table ── --}}
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
            {{-- Table header --}}
            <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 border-b border-outline-variant bg-surface-container-low">
                <div class="col-span-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Name</div>
                <div class="col-span-2 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Slug</div>
                <div class="col-span-3 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Description</div>
                <div class="col-span-1 font-ui-label text-ui-label text-secondary uppercase tracking-wider text-center">Posts</div>
                <div class="col-span-2 font-ui-label text-ui-label text-secondary uppercase tracking-wider text-right">Actions</div>
            </div>

            {{-- Rows --}}
            @forelse ($categories as $category)
                <div class="category-row grid grid-cols-12 gap-4 px-6 py-4 border-b border-outline-variant last:border-0 items-center hover:bg-surface-container-low transition-colors group fade-in">

                    {{-- Name + parent badge --}}
                    <div class="col-span-12 md:col-span-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-fixed flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary text-[16px]">
                                {{ $category->parent_id ? 'subdirectory_arrow_right' : 'folder' }}
                            </span>
                        </div>
                        <div>
                            <p class="font-ui-label text-ui-label font-semibold text-on-surface">{{ $category->name }}</p>
                            @if ($category->parent)
                                <p class="text-metadata font-metadata text-secondary mt-0.5">
                                    under <span class="text-primary font-medium">{{ $category->parent->name }}</span>
                                </p>
                            @else
                                <p class="text-metadata font-metadata text-secondary mt-0.5">Top-level</p>
                            @endif
                        </div>
                    </div>

                    {{-- Slug --}}
                    <div class="col-span-12 md:col-span-2">
                        <code class="text-metadata font-metadata bg-surface-container px-2 py-1 rounded text-secondary break-all">
                            {{ $category->slug }}
                        </code>
                    </div>

                    {{-- Description --}}
                    <div class="col-span-12 md:col-span-3">
                        <p class="font-ui-label text-ui-label text-on-surface-variant line-clamp-2">
                            {{ $category->description ?: '—' }}
                        </p>
                    </div>

                    {{-- Post count --}}
                    <div class="col-span-12 md:col-span-1 flex md:justify-center">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-primary font-metadata font-semibold text-[12px]">
                            <span class="material-symbols-outlined text-[14px]">article</span>
                            {{ $category->posts->count() }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="col-span-12 md:col-span-2 flex justify-end items-center gap-1 row-actions">
                        <a href="{{ route('categories.edit', $category->id) }}"
                           class="p-2 rounded-lg text-on-surface-variant hover:bg-primary-fixed hover:text-primary transition-all"
                           title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>

                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete \'{{ addslashes($category->name) }}\'? Posts in this category will be uncategorised.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 rounded-lg text-error hover:bg-error-container transition-all"
                                    title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 px-8 flex flex-col items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-[36px] text-secondary">category</span>
                    </div>
                    <h3 class="font-headline-md text-[20px] text-on-surface">No categories yet</h3>
                    <p class="font-ui-label text-ui-label text-secondary max-w-sm">
                        Create your first category to start organising your posts.
                    </p>
                    <a href="{{ route('categories.create') }}"
                       class="mt-2 inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full font-ui-label text-ui-label hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Create First Category
                    </a>
                </div>
            @endforelse
        </div>

        {{-- ── Pagination info ── --}}
        @if ($categories->isNotEmpty())
            <p class="mt-4 text-metadata font-metadata text-secondary text-right">
                {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }} total
            </p>
        @endif
    </main>
</x-layout>

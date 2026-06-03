<form action="{{ $action ?? route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (($method ?? 'POST') !== 'POST')
        @method($method)
    @endif


    <main class="pt-24 pb-32 flex flex-col lg:flex-row max-w-container-max mx-auto px-gutter gap-12">
        <!-- Editor Canvas -->
        <div class="flex-1 max-w-article-max mx-auto w-full distraction-free-focus">
            <div class="editor-container">
                @if ($errors->any())
                    <div class="mb-8 p-4 bg-error-container border border-error rounded-xl shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-error">error</span>
                            <h3 class="text-on-error-container font-ui-label text-ui-label tracking-wider uppercase">
                                Please fix the following errors:</h3>
                        </div>
                        <ul
                            class="list-disc list-inside space-y-1 ml-1 text-on-error-container font-metadata text-metadata">
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Title Field -->
                <textarea name="title"
                    class="w-full bg-transparent border-none focus:ring-0 font-display-lg text-display-lg resize-none placeholder:text-surface-variant text-on-surface mb-2 overflow-hidden"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Enter your title..."
                    rows="1">{{ old('title', $post->title ?? '') }}</textarea>
                @error('title')
                    <p class="mb-6 text-sm text-error font-metadata pl-2">{{ $message }}</p>
                @enderror

                <!-- Main Content Editor -->
                <textarea name="content" id="content"
                    class="w-full min-h-[400px] bg-transparent resize-none border-none focus:ring-0 focus:outline-none font-body-lg text-body-lg text-on-surface leading-relaxed placeholder:text-surface-variant p-2"
                    placeholder="Type your story...">{{ old('content', $post->content ?? '') }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-error font-metadata pl-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Section -->
            <div class="mt-12 pt-8 border-t border-outline-variant space-y-6">
                <h3 class="font-display-sm text-display-sm text-on-surface mb-6">SEO & Metadata</h3>

                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block font-ui-label text-ui-label text-on-surface mb-2">Meta Title</label>
                        <input type="text" name="meta[title]" id="meta_title"
                            value="{{ old('meta.title', $post->meta['title'] ?? '') }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="SEO optimized title">
                        @error('meta.title')
                            <p class="mt-2 text-sm text-error font-metadata">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="meta_description" class="block font-ui-label text-ui-label text-on-surface mb-2">Meta Description</label>
                        <textarea name="meta[description]" id="meta_description" rows="3"
                            class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                            placeholder="Brief description for search engines">{{ old('meta.description', $post->meta['description'] ?? '') }}</textarea>
                        @error('meta.description')
                            <p class="mt-2 text-sm text-error font-metadata">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_keywords" class="block font-ui-label text-ui-label text-on-surface mb-2">Keywords</label>
                            <input type="text" name="meta[keywords]" id="meta_keywords"
                                value="{{ old('meta.keywords', $post->meta['keywords'] ?? '') }}"
                                class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                                placeholder="e.g. laravel, php, development">
                            @error('meta.keywords')
                                <p class="mt-2 text-sm text-error font-metadata">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="meta_url" class="block font-ui-label text-ui-label text-on-surface mb-2">URL</label>
                            <input type="url" name="meta[url]" id="meta_url"
                                value="{{ old('meta.url', $post->meta['url'] ?? '') }}"
                                class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                                placeholder="https://example.com/slug">
                            @error('meta.url')
                                <p class="mt-2 text-sm text-error font-metadata">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Publishing Settings -->
        <aside
            class="hidden lg:block w-80 shrink-0 h-fit sticky top-24 sidebar-overlay transition-opacity duration-500">
            <div class="space-y-8 border-l border-outline-variant pl-8">
                <!-- Cover Image -->
                <section>
                    <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Cover Image
                    </h3>

                    {{-- Clickable drop zone --}}
                    <label for="cover_image_input"
                        class="relative aspect-video w-full rounded-lg bg-surface-container border-2 border-dashed border-outline-variant flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-surface-container-high transition-colors group overflow-hidden block">

                        {{-- Preview image (hidden until a file is chosen or post has one) --}}
                        @if (isset($post) && $post->cover_image)
                            <img id="cover-preview" src="{{ asset('storage/' . $post->cover_image) }}"
                                alt="Cover preview" class="absolute inset-0 w-full h-full object-cover" />
                        @else
                            <img id="cover-preview" src="" alt="Cover preview"
                                class="absolute inset-0 w-full h-full object-cover hidden" />
                        @endif

                        {{-- Overlay icon --}}
                        <div id="cover-placeholder"
                            class="flex flex-col items-center gap-2 {{ isset($post) && $post->cover_image ? 'opacity-0 group-hover:opacity-100 absolute inset-0 flex items-center justify-center bg-black/30 rounded-lg transition-opacity' : '' }}">
                            <span
                                class="material-symbols-outlined text-secondary group-hover:text-primary transition-colors">add_a_photo</span>
                            <span class="font-metadata text-metadata text-secondary">Upload high-res photo</span>
                        </div>
                    </label>

                    {{-- Hidden real file input --}}
                    <input id="cover_image_input" type="file" name="cover_image" accept="image/*" class="sr-only"
                        onchange="
                            const file = this.files[0];
                            if (!file) return;
                            const preview = document.getElementById('cover-preview');
                            const placeholder = document.getElementById('cover-placeholder');
                            preview.src = URL.createObjectURL(file);
                            preview.classList.remove('hidden');
                            placeholder.classList.add('opacity-0');
                        " />
                    @error('cover_image')
                        <p class="mt-2 text-sm text-error font-metadata text-center">{{ $message }}</p>
                    @enderror

                    {{-- Remove button (only if post already has a cover) --}}
                    @if (isset($post) && $post->cover_image)
                        <p class="mt-2 text-metadata font-metadata text-secondary text-center">
                            Choose a new image to replace the current cover.
                        </p>
                    @endif
                </section>

                <!-- Category -->
                <section>
                    <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Category</h3>
                    <div class="relative">
                        <select name="category_id" id="post-category"
                            class="w-full bg-white border border-outline-variant rounded-lg px-4 py-2 font-metadata text-metadata text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all appearance-none pr-8">
                            <option value="">— No category —</option>
                            @foreach ($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->parent ? $cat->parent->name . ' › ' : '' }}{{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-secondary pointer-events-none text-[18px]">expand_more</span>
                    </div>
                    @error('category_id')
                        <p class="mt-2 text-sm text-error font-metadata">{{ $message }}</p>
                    @enderror
                    @if (isset($categories) && $categories->isEmpty())
                        <p class="mt-2 text-metadata font-metadata text-secondary">
                            No categories yet —
                            <a href="{{ route('categories.create') }}" class="text-primary underline"
                                target="_blank">create one</a>
                        </p>
                    @endif
                </section>

                <!-- Publish Date -->
                <section>
                    <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Publish Date</h3>
                    <div class="relative">
                        <input type="datetime-local" name="published_at" id="published_at"
                            value="{{ old('published_at', isset($post) && $post->published_at ? (is_string($post->published_at) ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d\TH:i') : $post->published_at->format('Y-m-d\TH:i')) : '') }}"
                            class="w-full bg-white border border-outline-variant rounded-lg px-4 py-2 font-metadata text-metadata text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                    </div>
                    @error('published_at')
                        <p class="mt-2 text-sm text-error font-metadata">{{ $message }}</p>
                    @enderror
                </section>

                <!-- Tags -->
                <section>
                    <h3 class="font-ui-label text-ui-label text-on-surface mb-4 uppercase tracking-wider">Tags</h3>
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach ($post->tags ?? [] as $tag)
                            <span
                                class="bg-primary-fixed text-on-primary-fixed px-3 py-1 rounded-full font-metadata text-metadata flex items-center gap-1">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <input name="tags"
                        value="{{ old('tags', $post->exists ? $post->tags->pluck('name')->implode(', ') : '') }}"
                        class="w-full bg-white border border-outline-variant rounded-lg px-4 py-2 font-metadata text-metadata focus:ring-1 focus:ring-primary focus:border-primary transition-all"
                        placeholder="laravel, php, tutorial" type="text" />
                    @error('tags')
                        <p class="mt-2 text-sm text-error font-metadata">{{ $message }}</p>
                    @enderror
                </section>

                <!-- SEO Preview -->
                <section>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-ui-label text-ui-label text-on-surface uppercase tracking-wider">SEO Preview
                        </h3>
                        <button type="button"
                            class="text-primary font-metadata text-metadata hover:underline">Edit</button>
                    </div>
                    <div class="p-4 bg-white border border-outline-variant rounded-lg shadow-sm">
                        <div class="text-[#1a0dab] font-sans text-[18px] leading-tight mb-1 truncate"
                            id="seo-title-preview">
                            {{ $post->title ?? '' ?: 'The Art of Digital Quiet | Ink & Paper' }}
                        </div>
                        <div class="text-[#006621] font-sans text-[14px] mb-1 truncate">
                            {{ url('/posts/' . ($post->slug ?? '' ?: 'art-of-quiet')) }}
                        </div>
                        <p class="text-secondary font-sans text-[13px] line-clamp-2" id="seo-desc-preview">
                            {{ $post->content ?? '' ?: 'Discover how a distraction-free writing environment can transform your creative process and help you find your voice in a noisy world...' }}
                        </p>
                    </div>
                </section>

                <!-- Visibility / Status Toggle -->
                <section class="pt-4 border-t border-outline-variant">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span
                            class="font-ui-label text-ui-label text-secondary group-hover:text-on-surface transition-colors">Public
                            Post</span>
                        <div class="relative inline-flex items-center">
                            <input name="status" value="published" class="sr-only peer" type="checkbox"
                                {{ isset($post) && $post->status === 'published' ? 'checked' : '' }} />
                            <div
                                class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </div>
                    </label>
                </section>

                <!-- Actions -->
                <section class="pt-4 mt-8 border-t border-outline-variant flex flex-col gap-2">
                    <button type="submit"
                        class="w-full bg-primary text-white py-3 px-4 rounded-full font-ui-label text-ui-label uppercase tracking-wider hover:opacity-90 transition-opacity flex justify-center items-center gap-2">
                        <span class="material-symbols-outlined">publish</span>
                        {{ $title ?? 'Publish Post' }}
                    </button>
                    <a href="{{ route('posts.index') }}"
                        class="w-full bg-surface-container text-on-surface py-3 px-4 rounded-full font-ui-label text-ui-label uppercase tracking-wider hover:bg-surface-container-high text-center transition-colors flex justify-center items-center gap-2">
                        Cancel
                    </a>
                </section>
            </div>
        </aside>
    </main>
</form>

<script>
    tinymce.init({
        selector: '#content',
        plugins: [
            // Core editing features
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media',
            'searchreplace', 'table', 'visualblocks', 'wordcount',
            // Your account includes a free trial of TinyMCE premium features
            // Try the most popular premium features until Jun 15, 2026:
            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker',
            'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate',
            'tinymceai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes',
            'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword',
            'exportpdf'
        ],
        toolbar: 'undo redo | tinymceai-chat tinymceai-quickactions tinymceai-review | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            },
        ],
        tinymceai_token_provider: async () => {
            await fetch(
                `https://demo.api.tiny.cloud/1/pfai0o5myakjgxyslwuu2rlzkcdp782oxxhl26nuk74k3kgx/auth/random`, {
                    method: "POST",
                    credentials: "include"
                });
            return {
                token: await fetch(
                    `https://demo.api.tiny.cloud/1/pfai0o5myakjgxyslwuu2rlzkcdp782oxxhl26nuk74k3kgx/jwt/tinymceai`, {
                        credentials: "include"
                    }).then(r => r.text())
            };
        },
        uploadcare_public_key: '0571368acba12d9d512e',
    });
</script>

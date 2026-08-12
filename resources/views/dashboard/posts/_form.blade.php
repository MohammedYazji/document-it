<form action="{{ $action ?? route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (($method ?? 'POST') !== 'POST') @method($method) @endif

    <!-- Top Bar -->
    <div class="sticky top-12 z-40 bg-surface/95 backdrop-blur-sm border-b border-outline-variant h-12">
        <div class="flex items-center justify-between h-full px-4 max-w-6xl mx-auto">
            <a href="{{ route('posts.index') }}" class="text-sm text-on-surface-variant hover:text-on-surface transition-colors">$ cancel</a>
            <button type="button" id="preview-toggle" class="text-xs text-on-surface-variant hover:text-primary transition-colors">[preview]</button>
        </div>
    </div>

    @if ($errors->any())
        <div class="max-w-6xl mx-auto w-full px-4 mt-4">
            <div class="p-3 bg-error/10 border border-error/30 rounded text-sm text-error">
                <span class="font-bold">!</span> {{ $errors->first() }}
            </div>
        </div>
    @endif

    <!-- Two Column Layout -->
    <div class="max-w-6xl mx-auto w-full px-4 py-6 flex gap-6">
        <!-- Left: Editor -->
        <div class="flex-1 min-w-0 space-y-4">
            <textarea name="title"
                class="w-full bg-transparent border-none focus:ring-0 text-2xl md:text-3xl font-bold resize-none placeholder:text-on-surface-variant/20 text-on-surface overflow-hidden"
                oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="write your title..."
                rows="1">{{ old('title', $post->title ?? '') }}</textarea>
            @error('title') <p class="text-xs text-error">{{ $message }}</p> @enderror

            <div class="relative">
                <textarea name="content" id="content"
                    class="w-full min-h-[60vh] bg-transparent resize-none border-none focus:ring-0 focus:outline-none text-sm leading-relaxed placeholder:text-on-surface-variant/20 text-on-surface"
                    style="font-family: 'Courier New', Courier, monospace;"
                    placeholder="> write markdown here...

# Heading 1
## Heading 2

**bold** and *italic*

- list item
- another item

`inline code`

```
code block
```

> blockquote

[link](url)">{{ old('content', $post->content ?? '') }}</textarea>
                <div id="preview" class="hidden w-full min-h-[60vh] prose-terminal text-sm leading-relaxed p-2"></div>
            </div>
            @error('content') <p class="text-xs text-error">{{ $message }}</p> @enderror
        </div>

        <!-- Right: Settings -->
        <div class="hidden md:block w-56 shrink-0 space-y-4">
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ category</label>
                <select name="category_id" class="w-full bg-surface-container border border-outline-variant rounded px-2 py-1.5 text-xs focus:ring-1 focus:ring-primary focus:border-primary transition-all text-on-surface">
                    <option value="">none</option>
                    @foreach ($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->parent ? $cat->parent->name . ' > ' : '' }}{{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ tags</label>
                <input name="tags" value="{{ old('tags', $post->exists ? $post->tags->pluck('name')->implode(', ') : '') }}"
                    class="w-full bg-surface-container border border-outline-variant rounded px-2 py-1.5 text-xs focus:ring-1 focus:ring-primary focus:border-primary transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="tag1, tag2" type="text" />
            </div>
            <div class="border-t border-outline-variant pt-4">
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ cover</label>
                <div id="cover-preview-wrapper" class="relative {{ isset($post) && $post->cover_image ? '' : 'hidden' }} mb-2">
                    <img id="cover-preview-img" class="w-full h-32 object-cover rounded-lg border border-outline-variant" src="{{ isset($post) && $post->cover_image ? asset('storage/' . $post->cover_image) : '' }}" alt="" />
                    <button type="button" onclick="document.getElementById('cover-preview-wrapper').classList.add('hidden'); document.getElementById('cover_image_input').value = '';" class="absolute top-1 right-1 bg-error/80 text-white text-xs px-1.5 py-0.5 rounded">x</button>
                </div>
                <input id="cover_image_input" type="file" name="cover_image" accept="image/*"
                    class="w-full text-[10px] text-on-surface-variant file:mr-1 file:py-1 file:px-1.5 file:rounded file:border file:border-outline-variant file:text-[10px] file:bg-surface-container file:text-on-surface"
                    onchange="const f=this.files[0]; if(f){ const r=new FileReader(); r.onload=e=>{ document.getElementById('cover-preview-img').src=e.target.result; document.getElementById('cover-preview-wrapper').classList.remove('hidden'); }; r.readAsDataURL(f); }" />
            </div>
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ publish</label>
                <input type="datetime-local" name="published_at"
                    value="{{ old('published_at', isset($post) && $post->published_at ? (is_string($post->published_at) ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d\TH:i') : $post->published_at->format('Y-m-d\TH:i')) : '') }}"
                    class="w-full bg-surface-container border border-outline-variant rounded px-2 py-1.5 text-xs focus:ring-1 focus:ring-primary focus:border-primary transition-all text-on-surface" />
            </div>
            <div class="border-t border-outline-variant pt-4">
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ seo title <span class="text-on-surface-variant/30">(ai if empty)</span></label>
                <input type="text" name="meta[title]" value="{{ old('meta.title', $post->meta['title'] ?? '') }}"
                    class="w-full bg-surface-container border border-outline-variant rounded px-2 py-1.5 text-xs focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="auto-generated">
            </div>
            <div>
                <label class="text-xs text-on-surface-variant/50 block mb-1">$ seo desc <span class="text-on-surface-variant/30">(ai if empty)</span></label>
                <input type="text" name="meta[description]" value="{{ old('meta.description', $post->meta['description'] ?? '') }}"
                    class="w-full bg-surface-container border border-outline-variant rounded px-2 py-1.5 text-xs focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="auto-generated">
            </div>
            <input type="hidden" name="status" id="status-field" value="{{ isset($post) && $post->status === 'published' ? 'published' : 'draft' }}">
            <div class="border-t border-outline-variant pt-4 space-y-1.5">
                <button type="button" id="ai" class="w-full bg-surface-container border border-outline-variant text-primary px-4 py-2 rounded text-sm hover:bg-surface-container-high transition-colors">
                    $ write with ai
                </button>
                <button type="submit" class="w-full bg-primary text-on-primary px-4 py-2 rounded text-sm hover:opacity-90 transition-opacity" onclick="document.getElementById('status-field').value='published'">
                    $ publish
                </button>
                <button type="submit" class="w-full bg-surface-container border border-outline-variant text-on-surface px-4 py-2 rounded text-sm hover:bg-surface-container-high transition-colors" onclick="document.getElementById('status-field').value='draft'">
                    $ save draft
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    const btn = document.getElementById('ai');
    const content = document.getElementById('content');
    const title = document.querySelector('textarea[name="title"]');
    const preview = document.getElementById('preview');
    const previewToggle = document.getElementById('preview-toggle');
    let isPreview = false;

    // Simple markdown parser
    function mdToHtml(md) {
        return md
            .replace(/^### (.*$)/gm, '<h3>$1</h3>')
            .replace(/^## (.*$)/gm, '<h2>$1</h2>')
            .replace(/^# (.*$)/gm, '<h1>$1</h1>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`([^`]+)`/g, '<code>$1</code>')
            .replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>')
            .replace(/^> (.*$)/gm, '<blockquote>$1</blockquote>')
            .replace(/^- (.*$)/gm, '<li>$1</li>')
            .replace(/\n/g, '<br>');
    }

    previewToggle?.addEventListener('click', function() {
        isPreview = !isPreview;
        if (isPreview) {
            preview.innerHTML = mdToHtml(content.value) || '<span class="text-on-surface-variant/30">nothing to preview</span>';
            preview.classList.remove('hidden');
            content.classList.add('hidden');
            this.textContent = '[edit]';
        } else {
            preview.classList.add('hidden');
            content.classList.remove('hidden');
            this.textContent = '[preview]';
        }
    });

    btn?.addEventListener('click', function(e) {
        e.preventDefault();
        const topic = title?.value?.trim();
        if (!topic) {
            title?.focus();
            return;
        }
        btn.disabled = true;
        btn.textContent = '$ generating...';
        const evtSource = new EventSource("{{ route('posts.ai') }}?message=" + encodeURIComponent(topic));
        evtSource.onmessage = function(event) {
            if (event.data === '[DONE]') {
                evtSource.close();
                btn.disabled = false;
                btn.textContent = '$ write with ai';
                return;
            }
            try {
                let d = JSON.parse(event.data);
                if (d?.delta) content.value += d.delta;
            } catch(e) {}
        };
        evtSource.onerror = function() {
            evtSource.close();
            btn.disabled = false;
            btn.textContent = '$ write with ai';
        };
    });
</script>

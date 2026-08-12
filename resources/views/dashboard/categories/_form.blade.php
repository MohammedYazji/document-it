<form action="{{ $action }}" method="POST">
    @csrf
    @if(($method ?? 'POST') !== 'POST') @method($method) @endif

    <main class="py-6 px-4 max-w-2xl mx-auto space-y-6">
        <div>
            <a href="{{ route('categories.index') }}" class="text-sm text-on-surface-variant hover:text-primary transition-colors">$ back</a>
            <h1 class="text-xl font-bold text-on-surface mt-2">{{ $formTitle ?? 'Category' }}</h1>
        </div>

        @if ($errors->any())
            <div class="p-3 bg-error/10 border border-error/30 rounded text-sm text-error">
                <span class="font-bold">!</span> {{ $errors->first() }}
            </div>
        @endif

        <div class="space-y-4">
            <div>
                <label class="text-xs text-on-surface-variant/50 uppercase tracking-widest block mb-1.5">$ name <span class="text-error">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30"
                    placeholder="Technology">
                @error('name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 uppercase tracking-widest block mb-1.5">$ slug</label>
                <div class="flex items-center bg-surface-container border border-outline-variant rounded px-3 py-2 text-sm">
                    <span class="text-on-surface-variant/50">{{ url('/') }}/</span>
                    <span id="slug-preview" class="text-primary ml-1">{{ old('name') ? \Illuminate\Support\Str::slug(old('name')) : ($category->slug ?? '') }}</span>
                </div>
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 uppercase tracking-widest block mb-1.5">$ description</label>
                <textarea name="description" rows="3"
                    class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface placeholder:text-on-surface-variant/30 resize-none"
                    placeholder="Optional description">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="text-xs text-on-surface-variant/50 uppercase tracking-widest block mb-1.5">$ parent</label>
                <select name="parent_id" class="w-full bg-surface border border-outline-variant rounded px-3 py-2 text-sm focus:ring-1 focus:ring-primary focus:border-primary transition-all text-on-surface">
                    <option value="">none (top-level)</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded text-sm hover:opacity-90 transition-opacity">
                $ {{ $submitLabel ?? 'save' }}
            </button>
            <a href="{{ route('categories.index') }}" class="text-sm text-on-surface-variant hover:text-on-surface transition-colors">$ cancel</a>
        </div>
    </main>
</form>

<script>
    const nameInput = document.getElementById('name');
    const slugPreview = document.getElementById('slug-preview');
    if (nameInput) nameInput.addEventListener('input', () => {
        slugPreview.textContent = nameInput.value.toLowerCase().trim().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '') || '...';
    });
</script>

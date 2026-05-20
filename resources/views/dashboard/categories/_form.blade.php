<form action="{{ $action }}" method="POST">
    @csrf
    @if(($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    <main class="pt-24 pb-32 max-w-container-max mx-auto px-gutter">
        <div class="max-w-2xl mx-auto">

            {{-- Page Header --}}
            <div class="mb-10">
                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center gap-1 text-secondary font-ui-label text-ui-label hover:text-primary transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Back to Categories
                </a>
                <h1 class="font-display-lg text-[32px] text-on-background">{{ $formTitle ?? 'Category' }}</h1>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-error-container border border-error rounded-xl shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-error">error</span>
                        <h3 class="text-on-error-container font-ui-label text-ui-label tracking-wider uppercase">Please fix the following errors:</h3>
                    </div>
                    <ul class="list-disc list-inside space-y-1 ml-1 text-on-error-container font-metadata text-metadata">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Flash --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 font-ui-label text-ui-label">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-8 space-y-6 shadow-sm">

                {{-- Name --}}
                <div>
                    <label for="name" class="block font-ui-label text-ui-label text-on-surface mb-2 uppercase tracking-wider">
                        Name <span class="text-error">*</span>
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $category->name ?? '') }}"
                        placeholder="e.g. Technology"
                        class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 font-ui-label text-ui-label text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-secondary"
                        required
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-error font-metadata">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug (read-only, auto-generated preview) --}}
                <div>
                    <label class="block font-ui-label text-ui-label text-on-surface mb-2 uppercase tracking-wider">
                        Slug <span class="text-secondary font-normal normal-case">(auto-generated)</span>
                    </label>
                    <div class="flex items-center bg-surface-container border border-outline-variant rounded-xl px-4 py-3 gap-2">
                        <span class="text-secondary font-ui-label text-ui-label truncate">{{ url('/') }}/</span>
                        <span id="slug-preview" class="font-ui-label text-ui-label text-primary font-medium">
                            {{ old('name') ? \Illuminate\Support\Str::slug(old('name')) : ($category->slug ?? '') }}
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block font-ui-label text-ui-label text-on-surface mb-2 uppercase tracking-wider">
                        Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Optional description for this category..."
                        class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 font-ui-label text-ui-label text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all resize-none placeholder:text-secondary"
                    >{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-error font-metadata">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Parent Category --}}
                <div>
                    <label for="parent_id" class="block font-ui-label text-ui-label text-on-surface mb-2 uppercase tracking-wider">
                        Parent Category <span class="text-secondary font-normal normal-case">(optional)</span>
                    </label>
                    <select
                        id="parent_id"
                        name="parent_id"
                        class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 font-ui-label text-ui-label text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                    >
                        <option value="">— None (top-level category) —</option>
                        @foreach ($parents as $parent)
                            <option
                                value="{{ $parent->id }}"
                                {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}
                            >
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-error font-metadata">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Actions --}}
            <div class="mt-8 flex items-center gap-4">
                <button type="submit"
                    class="bg-primary text-white px-8 py-3 rounded-full font-ui-label text-ui-label uppercase tracking-wider hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    {{ $submitLabel ?? 'Save Category' }}
                </button>
                <a href="{{ route('categories.index') }}"
                    class="bg-surface-container text-on-surface px-8 py-3 rounded-full font-ui-label text-ui-label uppercase tracking-wider hover:bg-surface-container-high transition-colors">
                    Cancel
                </a>
            </div>
        </div>
    </main>
</form>

<script>
    // Live slug preview as the user types the name
    const nameInput = document.getElementById('name');
    const slugPreview = document.getElementById('slug-preview');

    function toSlug(str) {
        return str.toLowerCase().trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    if (nameInput) {
        nameInput.addEventListener('input', () => {
            slugPreview.textContent = toSlug(nameInput.value) || '…';
        });
    }
</script>

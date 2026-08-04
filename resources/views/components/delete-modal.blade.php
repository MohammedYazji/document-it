@props(['name', 'type' => 'item'])

<div id="delete-modal-{{ Str::slug($name) }}" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/70" onclick="closeDeleteModal('{{ Str::slug($name) }}')"></div>
    <div class="relative bg-surface border border-outline-variant rounded-lg p-6 w-full max-w-md mx-4 space-y-4">
        <div class="flex items-center gap-2 text-sm">
            <span class="text-error font-bold">DANGER</span>
            <span class="text-on-surface-variant/30">|</span>
            <span class="text-on-surface-variant/50">delete {{ $type }}</span>
        </div>
        <div class="bg-surface-container border border-outline-variant rounded p-4 font-mono text-sm space-y-2">
            <p class="text-on-surface-variant/50">$ rm -rf {{ $name }}</p>
            <p class="text-on-surface-variant/30">type the command to confirm:</p>
            <div class="flex items-center gap-2">
                <span class="text-primary">$</span>
                <input type="text" id="delete-input-{{ Str::slug($name) }}"
                    class="flex-1 bg-transparent border-none focus:ring-0 text-on-surface text-sm font-mono outline-none placeholder:text-on-surface-variant/20"
                    placeholder="rm -rf {{ $name }}"
                    oninput="checkDeleteInput('{{ Str::slug($name) }}', '{{ addslashes($name) }}')" />
            </div>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal('{{ Str::slug($name) }}')"
                class="px-4 py-1.5 text-sm text-on-surface-variant hover:text-on-surface transition-colors">
                $ cancel
            </button>
            <button type="button" id="delete-confirm-{{ Str::slug($name) }}"
                onclick="confirmDelete('{{ Str::slug($name) }}')"
                class="px-4 py-1.5 text-sm bg-error/20 text-error border border-error/30 rounded hover:bg-error/30 transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                disabled>
                $ delete
            </button>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(slug) {
        document.getElementById('delete-modal-' + slug)?.classList.remove('hidden');
        document.getElementById('delete-input-' + slug)?.focus();
    }

    function closeDeleteModal(slug) {
        document.getElementById('delete-modal-' + slug)?.classList.add('hidden');
        const input = document.getElementById('delete-input-' + slug);
        if (input) input.value = '';
        checkDeleteInput(slug, '');
    }

    function checkDeleteInput(slug, name) {
        const input = document.getElementById('delete-input-' + slug);
        const btn = document.getElementById('delete-confirm-' + slug);
        if (input && btn) {
            btn.disabled = input.value.trim() !== 'rm -rf ' + name;
        }
    }

    function confirmDelete(slug) {
        document.getElementById('delete-form-' + slug)?.submit();
    }
</script>

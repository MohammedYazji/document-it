<x-layout title="Create Category">
    @include('dashboard.categories._form', [
        'category'    => $category,
        'parents'     => $parents,
        'action'      => route('categories.store'),
        'method'      => 'POST',
        'formTitle'   => 'New Category',
        'submitLabel' => 'Create Category',
    ])
</x-layout>

<x-layout title="Edit Category">
    @include('dashboard.categories._form', [
        'category'    => $category,
        'parents'     => $parents,
        'action'      => route('categories.update', $category->id),
        'method'      => 'PUT',
        'formTitle'   => 'Edit Category',
        'submitLabel' => 'Save Changes',
    ])
</x-layout>

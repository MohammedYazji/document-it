<x-layout title="Edit Post">
    @include('dashboard.posts._form', [
        'post'       => $post,
        'categories' => $categories,
        'action'     => route('posts.update', $post->id),
        'method'     => 'PUT',
        'title'      => 'Edit Post',
    ])
</x-layout>
<x-layout title="Create Post">
    @include('dashboard.posts._form', [
        'post' => $post,
        'action' => route('posts.store'),
        'method' => 'POST',
        'title' => 'Create Post',
    ])
</x-layout>
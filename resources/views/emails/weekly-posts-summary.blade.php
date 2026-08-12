<x-mail::message>
# Weekly Posts Summary

Here are the latest posts from this week:

@foreach ($posts as $post)
**{{ $post->title }}**  
{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }}

[Read more]({{ route('posts.show', $post->id) }})

@endforeach

<x-mail::button :url="route('home')">
Visit {{ config('app.name') }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

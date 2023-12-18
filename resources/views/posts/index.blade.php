<x-main-layout>
    <div class="px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <span class="text-2xl font-bold border-b">Ultimas publicações</span>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            @foreach ($posts as $post)
                <x-card-post
                    :href="route('posts.show', $post->slug)" 
                    image="{{ $post->image }}" 
                    title="{{ $post->title }}" 
                    date="{{ $post->created_at }}">
                    {!! $post->body !!}
                </x-card-post>
            @endforeach
        </div>
        {{$posts->render('vendor.pagination.simple-tailwind')}}
    </div>
</x-main-layout>

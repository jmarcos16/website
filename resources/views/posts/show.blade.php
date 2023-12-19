<x-main-layout>

    <x-slot name="title">
        {{ $post->title }}
    </x-slot>

    <div class="w-full h-56 bg-gradient-to-r from-gray-900 to-sky-900">
        <div class="flex flex-col items-start w-full h-full max-w-3xl gap-6 px-4 py-10 mx-auto">
            <span class="font-semibold text-blue-400">{{$post->created_at}}</span>
            <h1 class="text-4xl font-bold text-gray-200">
                {{ $post->title }}
            </h1>
        </div>
    </div>
    <div class="px-4 py-10 mx-auto">
        <x-markdown theme="github-dark" class="mx-auto text-lg font-normal leading-7 prose">
            {!! $post->body !!}
        </x-markdown>
    </div>
</x-main-layout>

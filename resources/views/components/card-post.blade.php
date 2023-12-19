@props([
    'image',
    'title',
    'date'
])
<a {{ $attributes->merge(['class' => 'col-span-1 py-5']) }}>
    {{-- 800x600 --}}
    <img src="{{ $image }}" alt="{{$title}}" style="width: 600px; height: 250px;" class="object-cover">
    <div class="flex gap-10 py-3">
        <span class="text-gray-500">{{ $date }}</span>
    </div>
    <div>
        <div class="text-2xl font-bold">{{$title}}</div>
        <span class="text-gray-500">
            {!! substr($slot, 0, 200) !!}
        </span>
    </div>
</a>
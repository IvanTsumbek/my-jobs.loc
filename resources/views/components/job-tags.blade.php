@props(['tags', 'limit' => 5])

@if($tags)
    <div class="flex flex-wrap gap-1 mt-2">
        @foreach(array_slice($tags, 0, $limit) as $tag)
            <span class="text-xs bg-gray-50 border border-gray-200 text-gray-500 px-2 py-0.5 rounded">
                {{ $tag }}
            </span>
        @endforeach
    </div>
@endif
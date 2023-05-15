@props(['img' => null, 'title' => null, 'subTitle' => null, 'path' => null])
<div class="flex items-center gap-x-4">
    @if ($img)
        <x-table.image :img="$img" />
    @endif
    @if ($title || $subTitle)
        <div>

            @if ($title)
                @if ($path)
                    <a class="text-indigo-600 font-medium" target='_blank' href={{ $path }}>
                        {{ $title }}
                    </a>
                @else
                    <div class="font-medium text-gray-800">
                        {{ $title }}
                    </div>
                @endif
            @endif
            @if ($subTitle)
                <div class="mt-0.5 text-gray-500 text-xs">
                    {{ $subTitle }}
                </div>
            @endif

        </div>
    @endif

</div>

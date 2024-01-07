@props(['item'])
<li>
    <a href="{{ route($item['route']) }}"
        class="flex items-center gap-3 rounded-md px-3 py-2
    {{ request()->routeIs($item['route'] . '*')
        ? 'bg-neutral-800 text-white'
        : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
        @svg($item['icon'], 'h-5 w-5 ')
        <span class="text-sm font-medium leading-6 text-white ">
            {{ $item['title'] }}
        </span>
    </a>
</li>

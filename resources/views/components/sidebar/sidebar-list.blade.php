@props(['listNavigation', 'title' => ''])
<div class="py-3 px-3 flex flex-col">
    @if ($title)
        <div class="text-xs font-semibold leading-6 text-neutral-400">{{ $title }}</div>
    @endif
    <ul role="list" class=" flex-1 flex flex-col gap-1 ">
        @foreach ($listNavigation as $item)
            <x-sidebar.sidebar-item :item="$item" />
        @endforeach
    </ul>
</div>

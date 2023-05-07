@props(['date'])
<div class="flex gap-x-3 whitespace-nowrap">
    <div>
        {!! $date->isoFormat('DD MMM YYYY hh:mm A') !!}
        <span class="text-xs text-gray-500 block">
            {!! $date->diffForHumans() !!}
        </span>
    </div>
    @if (now()->diffInMinutes($date) < 20)
        {{-- 20 MIN --}}
        <div>
            <x-badge color="green">recien</x-badge>
        </div>
    @endif
</div>

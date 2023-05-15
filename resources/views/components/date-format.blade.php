@props(['date'])
<div class="">
    <div class="whitespace-nowrap font-medium text-xs">
        {!! $date->isoFormat('DD MMM YYYY hh:mm A') !!}

    </div>

    {{-- 20 MIN --}}
    <div class="flex items-center gap-x-4 mt-1">
        <span class="text-xs text-gray-500 block">
            {!! $date->diffForHumans() !!}
        </span>
        @if (now()->diffInMinutes($date) < 120)
            <span class="text-green-500 text-xs font-medium">recien</span>
        @endif
    </div>

</div>

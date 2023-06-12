@props(['date'])
<div class="text-sm">
    <div class="whitespace-nowrap font-medium uppercase text-gray-600 ">
        {!! $date->isoFormat('DD MMM YYYY hh:mm A') !!}

    </div>

    {{-- 20 MIN --}}
    {{-- <div class="flex items-center gap-x-4 mt-1">
        <span class=" text-gray-500 block">
            {!! $date->diffForHumans() !!}
        </span>
        @if (now()->diffInMinutes($date) < 120)
            <span class="text-green-500  font-medium">recien</span>
        @endif
    </div> --}}

</div>

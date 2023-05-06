@props(['percent'])
@php
    
    switch ($percent) {
        case $percent <= 33:
            $color = 'bg-red-500';
            break;
    
        case $percent <= 66:
            $color = 'bg-yellow-400';
            break;
    
        default:
            $color = 'bg-green-500';
            break;
    }
@endphp
<div class="{{ $color }} rounded-full w-4 h-4"></div>

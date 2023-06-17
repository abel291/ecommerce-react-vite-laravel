@props(['percent'])
@php
    
    switch (true) {
        case $percent <= 20:
            $color = 'bg-red-500';
            break;
    
        case $percent <= 50:
            $color = 'bg-yellow-400';
            break;
    
        default:
            $color = 'bg-gray-500';
            break;
    }
@endphp
<div class="{{ $color }} rounded-full w-4 h-4"></div>

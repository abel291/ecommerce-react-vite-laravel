@props(['stock'])
@php
    $percent = ($stock->remaining * 100) / $stock->quantity;
    switch (true) {
        case $percent <= 20:
            $color = 'bg-red-300';
            break;
    
        case $percent <= 50:
            $color = 'bg-yellow-200';
            break;
    
        default:
            $color = 'bg-green-300';
            break;
    }
@endphp
<div class="{{ $color }} rounded-full w-4 h-4"></div>

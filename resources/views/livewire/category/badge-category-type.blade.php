@php
    switch ($item->type) {
        case 'product':
            $color = 'orange';
            break;
    
        default:
            $color = 'purple';
            break;
    }
@endphp

<x-badge :color="$color" class="capitalize">
    {{ $item->type }}
</x-badge>

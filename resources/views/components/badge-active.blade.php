@props(['active'])
@if ($active)
    <x-badge color="green">Activo</x-badge>
@else
    <x-badge color="gray">Inactivo</x-badge>
@endif

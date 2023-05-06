@props(['label' => ''])
<div>
    <x-input-label for="{{ $attributes->whereStartsWith('wire:model')->first() }}">{{ $slot }}</x-input-label>
    <x-text-input id="{{ $attributes->whereStartsWith('wire:model')->first() }}" {{ $attributes }} />
    <x-input-error :model="$attributes->whereStartsWith('wire:model')->first()" />
</div>

@props(['disabled' => false, 'label' => ''])
@php
    $id = $attributes->whereStartsWith('wire:model')->first();
@endphp
<div>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>

    <select id="{{ $id }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 mt-2',
    ]) !!}>
        {{ $slot }}
    </select>

    <x-input-error :model="$id" />
</div>

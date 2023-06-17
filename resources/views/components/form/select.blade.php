@props(['disabled' => false, 'label' => '', 'placeholder' => 'Seleccione una opcion'])
@php
    $id = $attributes->whereStartsWith('wire:model')->first();
@endphp
<div>
    @if ($label)
        <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    @endif

    <select id="{{ $id }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => 'select-form mt-2',
    ]) !!}>
        <option value="">{{ $placeholder }}</option>
        {{ $slot }}
    </select>

    <x-input-error :model="$id" />
</div>

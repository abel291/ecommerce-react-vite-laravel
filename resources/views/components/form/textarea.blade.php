@props(['disabled' => false, 'label' => ''])
@php
    $id = $attributes->whereStartsWith('wire:model')->first();
@endphp
<div>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>

    <textarea id="{{ $id }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => 'input-textarea',
    ]) !!}></textarea>

    <x-input-error :model="$id" />
</div>

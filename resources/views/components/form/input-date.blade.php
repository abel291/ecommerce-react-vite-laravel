@props(['label' => ''])
@php
    $id = $attributes->whereStartsWith('wire:model')->first();
    $ref = 'd' . uniqid();
@endphp
<div>
    <x-input-label for="{{ $id }}">{{ $slot }}</x-input-label>

    <div x-data="{ value: @entangle($attributes->wire('model')) }">
        <x-text-input id="{{ $id }}" {{ $attributes->whereDoesntStartWith('wire:model') }}
            x-ref="{{ $ref }}" x-init="$nextTick(() => {
                flatpickr($refs.{{ $ref }}, {
                    locale: 'es',
                    dateFormat: 'Y-m-d',
                    altFormat: 'F j, Y',
                    altInput: true,
                    defaultDate: value,
                    onChange: function(selectedDates, dateStr, instance) {
                        value = dateStr
                    },
                })
            })" />

    </div>
    {{-- value = $event.target.value --}}
    <x-input-error :model="$id" />
</div>

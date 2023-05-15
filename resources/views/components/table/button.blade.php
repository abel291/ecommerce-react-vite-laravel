@props(['id' => null, 'modalId' => null, 'path' => null])
@if ($path)
    <a href="{{ $path }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
        {{ $slot }}
    </a>
@else
    <button x-data :key="'edit_' + {{ $id }}" class="text-indigo-600 hover:text-indigo-700 font-medium"
        x-on:click="$dispatch('{{ $modalId }}',{{ $id }})">
        {{ $slot }}
    </button>
@endif

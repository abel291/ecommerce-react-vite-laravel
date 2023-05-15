@props(['id' => null, 'pathEdit' => null, 'buttonShow' => false, 'buttonEdit' => true])
{{-- <div class="flex items-center justify-end gap-x-3">

    @if ($buttonShow)
        <button x-data :key="'show_' + {{ $id }}" class="text-indigo-600 font-medium"
            x-on:click="$dispatch('modal-show',{{ $id }})">
            Ver
        </button>
    @endif

    @if ($buttonEdit)
        @if ($pathEdit)
            <a href="{{ $pathEdit }}" class="text-indigo-600 font-medium">
                Editar
            </a>
        @else
            <button x-data :key="'edit_' + {{ $id }}" class="text-indigo-600 font-medium"
                x-on:click="$dispatch('modal-edit',{{ $id }})">
                Editar
            </button>
        @endif
    @endif

    {{ $slot }}

    <button class="text-red-600 font-medium " x-data :key="'delete_' + {{ $id }}"
        x-on:click="$dispatch('open-modal-confirmation-delete',{{ $id }})">Eliminar</button>
</div> --}}
<div class="flex items-center justify-end gap-x-3">
    {{ $slot }}
</div>

@props(['id'])
<button class="text-red-600 hover:text-red-700 font-medium " x-data :key="'delete_' + {{ $id }}"
    x-on:click="$dispatch('open-modal-confirmation-delete',{{ $id }})">Eliminar</button>

@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 my-4">
        <x-form.input-search />
        <div>
            <x-primary-button type="button" x-data=""
                class="btn-primary block h-full justify-center shadow-sm" x-on:click="$dispatch('modal-create-user')">
                Agregar {{ $label }}
            </x-primary-button>

        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Pais - Ciudad</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr class="text-sm">

                        <td class="whitespace-nowrap">
                            <x-table.title-image :title="$item->name" :sub-title="$item->email" />

                        </td>
                        <td class="text-neutral-500 ">
                            {{ $item->phone }}
                        </td>

                        <td class="text-neutral-500 ">
                            {{ $item->country }} - {{ $item->city }}
                        </td>

                        <td class="text-neutral-500 ">
                            @php
                                switch ($item->getRoleNames()->first()) {
                                    case 'admin':
                                        $color = 'bg-green-100 text-green-600 ring-green-600/20';
                                        break;

                                    default:
                                        $color = 'bg-neutral-100 text-neutral-600 ring-neutral-500/10';
                                        break;
                                }
                            @endphp

                            <x-badge class="{{ $color }} capitalize">
                                {{ $item->getRoleNames()->first() }}
                            </x-badge>
                        </td>

                        <td class="flex items-center justify-end gap-x-3">
                            <button x-data class="text-indigo-600 font-medium"
                                x-on:click="$dispatch('modal-show-user',{{ $item->id }})">
                                Ver
                            </button>
                            <button x-data class="text-indigo-600 font-medium"
                                x-on:click="$dispatch('modal-edit-user',{{ $item->id }})">
                                Editar
                            </button>
                            <button x-data class="text-red-600 font-medium "
                                x-on:click="$dispatch('open-modal-confirmation-delete',{{ $item->id }})">Eliminar</button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </x-table.table>
    </x-content>
    <livewire:user.create-user :label="$label" :label-plural="$labelPlural" />
    <livewire:user.show-user :label="$label" :label-plural="$labelPlural" />
</div>

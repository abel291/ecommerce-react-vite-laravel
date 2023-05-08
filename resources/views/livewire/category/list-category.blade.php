@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 my-4">
        <x-form.input-search />
        <div>
            <x-primary-button type="button" x-data=""
                class="btn-primary block h-full justify-center shadow-sm" x-on:click="$dispatch('modal-create')">
                Agregar {{ $label }}
            </x-primary-button>
        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search">
            <table class="w-full table-list">
                <thead>
                    <tr>
                        @php
                            $tableNamesHead = [
                                'name' => 'Nombre',
                                'type' => 'Tipo',
                                //'entry' => 'Descipcion',
                                'active' => 'Visible',
                                'updated_at' => 'Ultima actualización',
                            ];
                        @endphp

                        @foreach ($tableNamesHead as $key => $name)
                            <x-table.th :name="$name" />
                        @endforeach
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr class="text-sm">

                            <td class="whitespace-nowrap">
                                @if ($item->type == 'product')
                                    <a class="text-blue-500 font-medium" target='_blank'
                                        href={{ route('search', ['categories[]' => $item->slug]) }}>
                                        {{ $item->name }}
                                    </a>
                                @else
                                    <a class="text-blue-500 font-medium" target='_blank'
                                        href={{ route('blog', ['category' => $item->slug]) }}>
                                        {{ $item->name }}
                                    </a>
                                @endif
                                <span class="text-gray-500 text-xs block ">{{ $item->slug }}</span>
                            </td>

                            <td>
                                @include('livewire.category.badge-category-type')
                            </td>

                            <td class="text-gray-500 font-medium ">

                                <x-badge-active :active="$item->active" />
                            </td>

                            <td>
                                <x-date-format :date="$item->updated_at" />
                            </td>

                            <td>
                                <div class="flex items-center justify-end gap-x-3">
                                    <button x-data class="text-indigo-600 font-medium"
                                        x-on:click="$dispatch('modal-edit',{{ $item->id }})">
                                        Editar
                                    </button>

                                    <button x-data class="text-red-600 font-medium "
                                        x-on:click="$dispatch('open-modal-confirmation-delete',{{ $item->id }})">Eliminar</button>
                                </div>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-table.table>
    </x-content>
    <livewire:category.create-category :label="$label" :label-plural="$labelPlural" />

</div>

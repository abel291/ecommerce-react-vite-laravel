@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>
<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-2 mb-4">
        <x-desc-model :model-name="$modelName" :model-id="$modelId" />

        <div>
            <x-primary-button type="button" x-data=""
                class="btn-primary block h-full justify-center shadow-sm" x-on:click="$dispatch('modal-create')">
                Agregar {{ $label }}
            </x-primary-button>
        </div>
    </div>
    <x-content class="mt-5">

        <x-table.table :data="$list" wire:target="search">

            <thead>
                <tr>
                    @php
                        $tableNamesHead = [
                            'img' => 'Image',
                            'title' => 'Titulo',
                        
                            'sort' => 'orden',
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
                    <tr class="text-sm" wire:key="{{ $item->id }}">
                        <td>
                            <x-table.image :img="$item->img" :title="$item->title" />
                        </td>

                        <td class="text-gray-500">
                            {{ $item->title }}
                        </td>


                        <td class="text-gray-500">
                            {{ $item->sort }}
                        </td>

                        <td class="text-gray-500 font-medium ">
                            <x-badge-active :active="$item->active" />
                        </td>

                        <td>
                            <x-date-format :date="$item->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>
                                <x-table.button :id="$item->id" modal-id="modal-edit">Editar</x-table.button>
                                <x-table.button-delete :id="$item->id" />
                            </x-table.button-options>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </x-table.table>
    </x-content>
    <livewire:image.create-image :model-name="$modelName" :model-id="$modelId" :label="$label" :label-plural="$labelPlural" />
</div>

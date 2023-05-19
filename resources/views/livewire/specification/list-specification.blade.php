@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>
<div>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-2 mb-4">
        <x-table.description-lists :img="$product->img" title="Infomracion del producto" :data="[
            'Tipo' => 'Producto',
            'Nombre' => $product->name,
            'Categoria' => $product->category->name,
        ]" />

        <div>
            <x-primary-button type="button" x-data=""
                class="btn-primary block h-full justify-center shadow-sm" x-on:click="$dispatch('modal-create')">
                Agregar {{ $label }}
            </x-primary-button>
        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search">

            <thead>
                <tr>
                    @php
                        $tableNamesHead = [
                            'name' => 'Nombre',
                            'value' => 'Valor',
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
                            <x-table.title-image :title="$item->name" />
                        </td>

                        <td>
                            {{ $item->value }}
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
    <livewire:specification.create-specification :product-id="$product->id" :label="$label" :label-plural="$labelPlural" />
</div>

@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>
<div>

    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-2 mb-4">
        <x-table.description-lists :img="$product->img" title="Infomracion del producto" :data="[
            'Categoria' => $product->category->name,
            'Nombre' => $product->name,
        ]" />

        <div class="lg:flex gap-2">
            <div>
                <x-primary-button type="button" x-data=""
                    class="btn-primary block h-full justify-center shadow-sm"
                    x-on:click="$dispatch('modal-create-attribute')">
                    Agregar {{ $label }}
                </x-primary-button>
            </div>
            <div>
                <x-primary-button type="button" x-data=""
                    class="btn-primary block h-full justify-center shadow-sm"
                    x-on:click="$dispatch('modal-create-attribute-value')">
                    Agregar valor de atributo
                </x-primary-button>
            </div>
        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search">

            <thead>
                <tr>
                    @php
                        $tableNamesHead = [
                            'name' => 'Atributo',
                            'in_stock' => 'En stock',
                            'default' => 'Por defecto',
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
                @foreach ($list as $attribute)
                    <tr wire:key="attribute-{{ $attribute->id }}">

                        <td class="whitespace-nowrap">
                            <x-table.title-image :title="$attribute->name" />
                        </td>
                        <td></td>
                        <td></td>

                        <td>
                            <x-date-format :date="$attribute->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>
                                <button type="button" x-data
                                    :key="{{ $attribute->id . $attribute->slug }}"class="text-indigo-600 hover:text-indigo-700 font-medium"
                                    x-on:click="$dispatch('modal-edit-attribute',{{ $attribute->id }})">
                                    Editar
                                </button>
                                <button class="text-red-600 hover:text-red-700 font-medium " x-data
                                    :key="delete_attribute{{ $attribute->id }}"
                                    x-on:click="$dispatch('open-modal-confirmation-delete-attribute',{{ $attribute->id }})">Eliminar</button>

                            </x-table.button-options>
                        </td>

                    </tr>
                    @foreach ($attribute->attribute_values as $attribute_value)
                        <tr wire:key="attribute-value-{{ $attribute_value->id }}">
                            <td>
                                <div class="ml-4">
                                    <x-badge>{{ $attribute_value->name }}</x-badge>
                                </div>
                            </td>
                            <td>
                                @if ($attribute_value->in_stock)
                                    <x-badge color="green">Si</x-badge>
                                @else
                                    <x-badge>No</x-badge>
                                @endif

                            </td>
                            <td>
                                @if ($attribute_value->default)
                                    <x-badge color="green">Si</x-badge>
                                @endif
                            </td>

                            <td>
                                <x-date-format :date="$attribute_value->updated_at" />
                            </td>
                            <td>
                                <x-table.button-options>
                                    <button type="button" x-data
                                        class="text-indigo-600 hover:text-indigo-700 font-medium"
                                        x-on:click="$dispatch('modal-edit-attribute-value',{{ $attribute_value->id }})">
                                        Editar
                                    </button>
                                    <button class="text-red-600 hover:text-red-700 font-medium " x-data
                                        :key="'delete_attribute_value' + {{ $attribute_value->id }}"
                                        x-on:click="$dispatch('modal-confirmation-delete-attribute-value',{{ $attribute->id }})">Eliminar</button>
                                </x-table.button-options>
                            </td>

                        </tr>
                    @endforeach
                @endforeach
            </tbody>

        </x-table.table>
    </x-content>
    <livewire:attribute.create-attribute :product-id="$product->id" :label="$label" :label-plural="$labelPlural" />
    <livewire:attribute.create-attribute-value :product-id="$product->id" :label="$label" :label-plural="$labelPlural" />
</div>

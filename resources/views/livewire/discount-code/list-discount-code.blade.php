@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-2 my-4">
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
            <thead>

                <tr>
                    @php
                        $tableNamesHead = [
                            'code' => 'Codigo',
                            'name' => 'Nombre',
                            'value' => 'Valor',
                            //'orders_count' => 'Ordenes Aplicadas',
                            'start_date' => 'Tiempo valido',
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
                            <x-table.title-image :title="$item->code" />
                        </td>

                        <td>
                            {{ $item->name }}
                        </td>

                        <td>
                            @if ($item->type == \App\Enums\DiscountCodeTypeEnum::PERCENT)
                                <x-badge :color="$item->type->color()"> {{ $item->value }}%</x-badge>
                            @else
                                @money($item->value)
                            @endif
                        </td>
                        {{-- <td>
                            {{ $item->orders_count }}
                        </td> --}}
                        <td>
                            <div class="flex items-center gap-x-3">
                                <span class=" text-green-400 font-medium uppercase">
                                    {{ $item->valid_from->isoFormat('DD MMM YYYY') }}
                                </span>
                                al
                                <span class=" text-red-400 font-medium uppercase">
                                    {{ $item->valid_to->isoFormat('DD MMM YYYY') }}
                                </span>
                            </div>
                            <div class="text-gray-600 text-xs mt-1">
                                {{ $item->valid_from->diffInDays($item->valid_to) }} dia(s)
                            </div>
                        </td>
                        <td>
                            <x-badge-active :active="$item->active" />
                        </td>

                        <td>
                            <x-date-format :date="$item->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>
                                <x-table.button modal-id="modal-edit" :id="$item->id">Editar</x-table.button>
                                <x-table.button-delete :id="$item->id" />
                            </x-table.button-options>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </x-table.table>
    </x-content>


    <livewire:discount-code.create-discount-code :label="$label" :label-plural="$labelPlural" />
</div>

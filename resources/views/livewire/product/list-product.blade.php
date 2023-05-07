@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 my-4">
        <x-form.input-search />
        <div>
            <a href="{{ route('dashboard.create-product') }}" class="btn-primary block h-full justify-center shadow-sm">
                Agregar {{ $label }}
            </a>

        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search">
            <table class="w-full table-list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Ventas del Año</th>
                        <th>Ultima actualización</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr class="text-sm">

                            <td class="text-gray-500 ">
                                {{ $item->id }}
                            </td>

                            <td class="text-gray-900 font-medium  whitespace-nowrap">

                                <div class="flex items-center ">
                                    <div class="">
                                        <img class="w-auto h-8" src="{{ $item->img }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <a target='_blank' href={{ route('product', $item->slug) }}>
                                            {{ $item->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td class="text-gray-500 ">
                                <x-badge class="bg-blue-100 text-blue-700 capitalize whitespace-nowrap">
                                    {{ $item->category->name }}
                                </x-badge>
                            </td>

                            <td class="">

                                <div class="">
                                    @if ($item->offer)
                                        <span class="block line-through text-gray-400 text-xs">@money($item->price)</span>
                                    @endif
                                    <span class="block text-grayu-700 font-medium">@money($item->price_offer)</span>
                                </div>
                            </td>

                            <td class="text-gray-500 font-medium ">

                                <div class="flex items-center gap-x-1.5">

                                    <x-table.stock-percent :percent="$item->stock->stock_percent" />
                                    <span class="">
                                        {{ $item->stock->remaining }}

                                    </span>
                                </div>
                            </td>

                            <td class="text-gray-500 text-center ">
                                {{ $item->orders_count }}
                            </td>

                            <td class="text-gray-500 ">
                                {{ $item->updated_at->diffForHumans() }}
                            </td>

                            <td>
                                <div class="flex items-center justify-end gap-x-3">
                                    <a href="{{ route('dashboard.edit-product', $item->id) }}"
                                        class="text-indigo-600 font-medium">
                                        Editar
                                    </a>
                                    <button x-data class="text-indigo-600 font-medium"
                                        x-on:click="$dispatch('modal-show-user',{{ $item->id }})">
                                        Ver
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

    <x-modal-confirmation-delete />
</div>

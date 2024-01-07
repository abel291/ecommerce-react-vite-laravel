@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-2 my-4">

        <div class="flex items-end gap-x-3">
            <x-form.input-search />
            <x-form.select wire:model="category_id" label="Categorias">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-form.select>
        </div>

        <div>
            <a href="{{ route('dashboard.products-create') }}" class="btn-primary block h-full justify-center shadow-sm">
                Agregar {{ $label }}
            </a>
        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search,category_id">

            <thead>
                <tr>

                    <th>Nombre - slug</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Activo</th>
                    <th>Ultima actualización</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr class="text-sm">

                        <td>
                            <x-table.title-image :img="$item->img" :title="$item->name" :path="route('product', $item->slug)" />

                        </td>

                        <td class="text-neutral-500 ">
                            <x-badge class="bg-blue-100 text-blue-700 capitalize whitespace-nowrap">
                                {{ $item->category->name }}
                            </x-badge>
                        </td>

                        <td class=" whitespace-nowrap">

                            @if ($item->offer)
                                <span class="block line-through text-neutral-400 text-xs">@money($item->price)</span>
                            @endif
                            <span class="block text-grayu-700 font-medium">@money($item->price_offer)</span>
                        </td>

                        <td class="text-neutral-500 font-medium ">

                            <div class="flex items-center gap-x-1.5">

                                <x-table.stock-percent :stock="$item->stock" />
                                <span class="">
                                    {{ $item->stock->remaining }}/{{ $item->stock->quantity }}
                                </span>
                            </div>
                        </td>

                        <td class="text-neutral-500 font-medium ">

                            <x-badge-active :active="$item->active" />
                        </td>
                        <td>
                            <x-date-format :date="$item->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>

                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button class="text-indigo-600 font-medium flex items-center">
                                            <span>Editar</span>
                                            <x-heroicon-m-chevron-down class="h-4 w-4 ml-0.5" />
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link href="{{ route('dashboard.products-edit', $item->id) }}">
                                            Datos Basicos
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('dashboard.product-attributes', $item->id) }}">
                                            Atributos
                                        </x-dropdown-link>
                                        <x-dropdown-link
                                            href="{{ route('dashboard.products-specifications', $item->id) }}">
                                            Specificaciones
                                        </x-dropdown-link>
                                        <x-dropdown-link
                                            href="{{ route('dashboard.images', ['product', $item->id]) }}">
                                            Imagenes
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>

                                <x-table.button-delete :id="$item->id" />
                            </x-table.button-options>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </x-table.table>
    </x-content>

    <x-modal-confirmation-delete />
</div>

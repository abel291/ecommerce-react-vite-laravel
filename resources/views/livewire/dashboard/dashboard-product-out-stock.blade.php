<x-content>
    <h3 class="title mb-6">Productos con poco stock </h3>
    <x-table.table :data="$products_out_stock" wire:target="previousPage,nextPage, gotoPage">

        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products_out_stock as $item)
                <tr class="text-sm">

                    <td>
                        <x-table.title-image :title="$item->name" />

                    </td>

                    <td class="">

                        <div class="whitespace-nowrap">
                            <span class="block text-grayu-700 font-medium">@money($item->price_offer)</span>
                        </div>
                    </td>

                    <td class="text-neutral-500 font-medium ">
                        <div class="flex items-center gap-x-1.5">

                            <x-table.stock-percent :stock="$item->stock" />
                            <span class="">
                                {{ $item->stock->remaining }}/{{ $item->stock->quantity }}
                            </span>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>

    </x-table.table>
</x-content>

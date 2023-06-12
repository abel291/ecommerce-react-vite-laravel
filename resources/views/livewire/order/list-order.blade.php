@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:items-end gap-2 my-4">
        <x-form.input-search />
        <x-form.select wire:model="status" label="Estado de compra">
            <option value="">Todas</option>
            @foreach (\App\Enums\PaymentStatus::cases() as $item)
                <option value="{{ $item->value }}">{{ $item->text() }}</option>
            @endforeach
        </x-form.select>
        <div>
            {{-- <a class="btn-primary block h-full justify-center shadow-sm" href="{{ route('dashboard.posts-create') }}">
                Crear {{ $label }}
            </a> --}}
        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search,status">
            <thead>
                <tr>
                    @php
                        $tableNamesHead = [
                            'code' => 'Codigo',
                            'user_data->name' => 'Cliente',
                            'order_products_count' => 'N° productos',
                            'status' => 'Estado',
                            'total' => 'Total',
                            'updated_at' => 'Fecha',
                        ];
                    @endphp

                    @foreach ($tableNamesHead as $key => $name)
                        <x-table.th :name="$name" />
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($list as $item)
                    <tr key="data-{{ $item->id }}">

                        <td class="whitespace-nowrap">

                            <x-table.title-image :title="'#' . $item->code" />
                        </td>
                        <td>
                            {{ $item->user_data->name }}
                        </td>
                        <td>
                            <div class="flex items-center gap-x-3">

                                <x-table.button :id="$item->id" modal-id="modal-quantity-product">
                                    <span class="underline">{{ $item->order_products->sum('quantity_selected') }}</span>
                                </x-table.button>
                            </div>
                        </td>
                        <td>
                            <x-badge :color="$item->payment->status->color()">{{ $item->payment->status->text() }}</x-badge>
                        </td>
                        <td>
                            <span
                                class="font-semibold text-{{ $item->payment->status->color() }}-600">@money($item->total)</span>
                        </td>
                        <td>
                            <x-date-format :date="$item->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>
                                <x-table.button :id="$item->id" :path="route('dashboard.orders-show', $item->id)">Ver</x-table.button>
                            </x-table.button-options>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </x-table.table>
    </x-content>

    {{-- <livewire:order.view-order :label="$label" :label-plural="$labelPlural" /> --}}
    <livewire:order.view-product :label="$label" />
</div>

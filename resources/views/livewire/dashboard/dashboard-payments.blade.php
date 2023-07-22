<x-card>
    <x-slot:title>
        <div class="lg:flex justify-between">
            <span>Ultimas transacciones</span>
            <a class="font-medium text-indigo-600 text-sm" href="{{ route('dashboard.orders') }}">Ver mas</a>
        </div>
    </x-slot:title>
    <div>
        <table class="table-list table-auto w-full">
            <thead>
                <tr>
                    <th> Codigo de orden</th>
                    <th> Nombre</th>
                    <th> Estado</th>
                    <th> Total</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $item)
                    <tr key="data-{{ $item->id }}">

                        <td class="whitespace-nowrap">

                            <x-table.title-image :title="'#' . $item->order->code" />
                        </td>
                        <td>
                            {{ $item->order->data->user->name }}
                        </td>

                        <td>
                            <x-badge :color="$item->status->color()">{{ $item->status->text() }}</x-badge>
                        </td>
                        <td>
                            <span
                                class="font-semibold text-{{ $item->status->color() }}-600 whitespace-nowrap">@money($item->order->total)</span>
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
        </table>
    </div>
</x-card>

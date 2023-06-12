@section('title', $label . ' #' . $order->code)
<x-slot name="header">
    Pedido: <span class="font-semibold"> #{{ $order->code }}</span>
</x-slot>
<div>
    <x-content>

        <div class="flex gap-4">
            <div class="lg:w-8/12">
                <x-form.title>Detalles de la compra</x-form.title>
                <dl class=" divide-y divide-gray-100">

                    <x-list-description title="Codigo" :desc="$order->code">
                        <x-slot:desc>
                            <span class="font-medium">{{ $order->code }}</span>
                        </x-slot:desc>
                    </x-list-description>

                    <x-list-description title="Datos del cliente">
                        <x-slot:desc>
                            <div>{{ $order->user_data->name }}</div>
                            <div>{{ $order->user_data->email }}</div>
                            <div>{{ $order->user_data->phone }}</div>
                        </x-slot:desc>
                    </x-list-description>

                    <x-list-description title="Direccion de envio">
                        <x-slot:desc>
                            <div>{{ $order->user_data->address }}</div>
                            <div>{{ $order->user_data->city }}</div>
                        </x-slot:desc>
                    </x-list-description>

                    <x-list-description title="Fecha del pedido">
                        <x-slot:desc>
                            <x-date-format :date="$order->updated_at" />
                        </x-slot:desc>
                    </x-list-description>

                </dl>
            </div>

            <div class="lg:w-4/12">
                <livewire:order.payment-order :order="$order" />
            </div>

        </div>
        <div class="mt-20">
            <x-form.title>Pedido</x-form.title>
            <div>
                <ul class="mt-4 divide-y border-t">
                    @foreach ($order->order_products as $item)
                        @include('livewire.order.card-product', ['item' => $item])
                    @endforeach

                </ul>
                <div class="border-t">
                    <dl class="sm:max-w-sm font-medium text-sm pt-4 space-y-4  ml-auto">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Productos</dt>
                            <dd class="text-gray-900 ">{{ $order->order_products->sum('quantity_selected') }}
                            </dd>
                        </div>


                        <div class="flex justify-between">
                            <dt class="text-gray-500">Subtotal</dt>
                            <dd class="text-gray-900 ">@money($order->sub_total)</dd>
                        </div>
                        @if ($order->discount)
                            <div class="flex justify-between text-green-500">
                                <dt>
                                    Descuento
                                    @if ($order->discount->type == 'percent')
                                        {{ $order->discount->value }}%
                                    @endif
                                </dt>
                                <dd>-@money($order->discount->applied)</dd>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Envio</dt>
                            <dd class="text-gray-900 ">@money($order->shipping)</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Impuestos {{ $order->tax_percent }}%</dt>
                            <dd class="text-gray-900 ">@money($order->tax_amount)</dd>
                        </div>
                        <div class="flex justify-between pt-4 text-base  border-t">
                            <dt>Total</dt>
                            <dd class="text-gray-900 font-semibold">@money($order->total)</dd>
                        </div>
                    </dl>
                </div>


            </div>
        </div>

    </x-content>
    <div class="mt-5 flex items-center justify-end gap-x-2">
        <a class="btn-secondary" href="{{ route('dashboard.orders') }}">Volver</a>
    </div>
</div>

@section('title', $label . ' #' . $order->code)
<x-slot name="header">
    Pedido: <span class="font-semibold"> #{{ $order->code }}</span>
</x-slot>
<div>
    <x-content class="max-w-3xl mx-auto">

        <div class="space-y-5 divide-y divide-neutral-200">
            <div>
                <x-form.title>Detalles de la compra</x-form.title>
                <dl class=" divide-y divide-neutral-100">

                    <x-list-description title="Codigo" :desc="$order->code">
                        <x-slot:desc>
                            <span class="font-medium">{{ $order->code }}</span>
                        </x-slot:desc>
                    </x-list-description>

                    <x-list-description title="Datos del cliente">
                        <x-slot:desc>
                            <div>{{ $order->data->user->name }}</div>
                            <div>{{ $order->data->user->email }}</div>
                            <div>{{ $order->data->user->phone }}</div>
                        </x-slot:desc>
                    </x-list-description>

                    <x-list-description title="Direccion de envio">
                        <x-slot:desc>
                            <div>{{ $order->data->user->address }}</div>
                            <div>{{ $order->data->user->city }}</div>
                        </x-slot:desc>
                    </x-list-description>

                    <x-list-description title="Fecha del pedido">
                        <x-slot:desc>
                            <x-date-format :date="$order->updated_at" />
                        </x-slot:desc>
                    </x-list-description>

                </dl>
            </div>

            {{-- <div>
                <livewire:order.payment-order :order="$order" />
            </div> --}}
            <div class="pt-5">
                <x-form.title>Items</x-form.title>

                <div class="">

                    <div>
                        <ul class="divide-y ">
                            @foreach ($order->order_products as $item)
                                @include('livewire.order.card-product', ['item' => $item])
                            @endforeach

                        </ul>
                    </div>


                </div>
            </div>
            <div class="pt-5 flex justify-end">
                <dl class="sm:max-w-sm w-96 font-medium text-sm space-y-4 ">
                    <div class="flex justify-between">
                        <dt class="text-neutral-500">Productos</dt>
                        <dd class="text-neutral-900 ">{{ $order->quantity }}
                        </dd>
                    </div>


                    <div class="flex justify-between">
                        <dt class="text-neutral-500">Subtotal</dt>
                        <dd class="text-neutral-900 ">@money($order->sub_total)</dd>
                    </div>
                    @if ($order->discount)
                        <div class="flex justify-between text-green-500">
                            <dt>
                                Descuento
                                @if ($order->discount->type == 'percent')
                                    {{ $order->discount->value }}%
                                @endif
                                <x-badge class="ml-2" color="gray">
                                    {{ $order->discount->code }}
                                </x-badge>
                            </dt>
                            <dd>-@money($order->discount->applied)</dd>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-neutral-500">Envio</dt>
                        <dd class="text-neutral-900 ">@money($order->shipping)</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-500">Impuestos {{ $order->tax_rate }}%</dt>
                        <dd class="text-neutral-900 ">@money($order->tax_value)</dd>
                    </div>
                    <div class="flex justify-between pt-4 text-base  border-t">
                        <dt>Total</dt>
                        <dd class="text-neutral-900 font-semibold">@money($order->total)</dd>
                    </div>
                </dl>
            </div>
        </div>

    </x-content>
    <div class="mt-5 flex items-center justify-end gap-x-2">
        <a class="btn-secondary" href="{{ route('dashboard.orders') }}">Volver</a>
    </div>
</div>

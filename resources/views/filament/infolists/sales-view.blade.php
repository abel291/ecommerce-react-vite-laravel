<div>
    @php
        // dd($getRecord()->discount);
    @endphp
    <div class=" table-list-wrp">
        <table class="table-list">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getState() as $product)
                    <tr>
                        <td>
                            <img src={{ $product->thumb }} alt="" class="h-12 rounded">
                        </td>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td class="whitespace-nowrap">
                            {{ Number::currency($product->price) }}
                        </td>
                        <td align="center">
                            {{ $product->quantity }}
                        </td>
                        <td class="whitespace-nowrap">
                            {{ Number::currency($product->total) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-8 flex justify-end ">
        <dl class="sm:max-w-sm w-80 font-medium text-sm space-y-5 ">
            <x-descripction-list title="Sub total" :description="Number::currency($getRecord()->sub_total)" />
            @if ($getRecord()->discount)
                <x-descripction-list :title="'Descuento ' . $getRecord()->discount['value'] . '%'" :description="'-$ ' . Number::format($getRecord()->discount['applied'])" />
            @endif
            <x-descripction-list title="Envio" :description="Number::currency($getRecord()->shipping)" />
            <x-descripction-list title="Total" :description="Number::currency($getRecord()->total, in: 'USD', locale: 'de')" />
        </dl>
    </div>



</div>

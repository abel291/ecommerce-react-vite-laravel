<div class="table-list-wrp">
    <table class="table-list ">
        <thead>
            <tr>
                <th>Codigo</th>
                <th class="">Nombre</th>
                <th>Cantidad</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getState() as $product)
                <tr>
                    <td>
                        {{ $product->barcode }}
                    </td>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        {{ $product->pivot->quantity }}
                    </td>
                    <td class="whitespace-nowrap">
                        {{ Number::currency($product->pivot->cost) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

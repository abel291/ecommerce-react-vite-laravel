<div class="table-list-wrp">
    <table class="table-list">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio detal</th>
                <th>Precio mayorista</th>
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
                        {{ Number::currency($product->price) }}
                    </td>
                    <td class="whitespace-nowrap">
                        {{ Number::currency($product->price_wholesale) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

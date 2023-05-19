<li class="flex py-4 gap-x-4 text-sm font-medium items-center">
    <div class="w-12 h-12 flex justify-center items-center rounded-md border p-1">
        <img src="{{ $item->product->img }}" alt="" class="max-w-full h-auto max-h-full ">
    </div>
    <div class="grow space-y-1 text-gray-500 ">
        <h3 class="text-gray-900 ">
            {{ $item->name }}
        </h3>
        <p>
            @money($item->price) por unidad.
        </p>
    </div>
    <div class="flex flex-col gap-y-1 items-end">
        <p class="text-gray-900">@money($item->price_quantity)</p>
        <p class="text-gray-500 font-normal">
            {{ $item->quantity }} unidades.
        </p>
    </div>

</li>

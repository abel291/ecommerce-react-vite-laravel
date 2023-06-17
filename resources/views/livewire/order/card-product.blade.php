<li class="flex py-4 gap-x-4 text-sm font-medium items-strech">
    <div class="w-16 h-16 flex justify-center items-center rounded-md border p-1">
        <img src="{{ $item->product->img }}" alt="" class="w-full">
    </div>
    <div class="grow">
        <div>
            <h3 class="font-medium">
                {{ $item->name }}
            </h3>
            <p class="text-gray-500 mt-1">
                @money($item->price) por unidad.
            </p>
        </div>
    </div>
    <div class="flex flex-col gap-y-1 items-end">
        <p class="text-gray-900 whitespace-nowrap">@money($item->price_quantity)</p>
        <p class="text-gray-500 whitespace-nowrap font-normal">
            {{ $item->quantity_selected }} unidades.
        </p>
    </div>

</li>

<li class="flex py-4 gap-x-4 text-sm font-medium items-strech">
    <div class="w-16 flex justify-center items-center rounded-md overflow-hidden">
        <img src="{{ $item->product->img }}" alt="" class="w-full">
    </div>
    <div class="grow">
        <div>
            <h3 class="font-medium">
                {{ $item->data->name }}
            </h3>
            <div class=" inline-grid grid-cols-2 mt-1 gap-x-2 gap-y-1 text-xs">
                @foreach ($item->attributes as $attribute)
                    <div>{{ $attribute->name }}</div>
                    <div class="text-neutral-500">{{ $attribute->value }}</div>
                @endforeach
            </div>



        </div>
    </div>
    <div class="flex flex-col gap-y-1 items-end">
        <p class="text-neutral-900 whitespace-nowrap">@money($item->total)</p>
        <p class="text-neutral-500 whitespace-nowrap font-normal">
            {{ $item->quantity }} unidades.
        </p>
        @if ($item->quantity > 1)
            <p class="text-neutral-500 mt-1 text-xs">
                @money($item->price) por unidad.
            </p>
        @endif
    </div>

</li>

<div>
    {{-- @if ($title)
        <div class="px-4 sm:px-0">
            <h3 class="text-base font-semibold leading-7 text-neutral-900">{{ $title }}</h3>
        </div>
    @endif --}}
    <div class="mt-2 border-t border-neutral-100 flex items-center gap-x-4">
        @if ($img)
            <div>
                <img src="{{ $img }}" class="h-20 w-20 object-cover rounded-full" alt="img card">
            </div>
        @endif
        <div class="divide-y divide-neutral-100 text-neutral-900">
            <table>
                <tbody>
                    @foreach ($descList as $key => $item)
                        <tr>
                            <td class="px-2 py-1 text-sm font-medium  ">{{ $key }}</td>
                            <td class="px-2 py-1 text-sm  text-neutral-700 sm:col-span-2">{{ $item }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</div>

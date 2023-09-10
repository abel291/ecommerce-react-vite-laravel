<x-form.section-form title="Asociaciones">
    <x-form.grid>

        <div class="md:col-span-2">

            <x-form.select wire:model.defer="product.category_id" label="Categoria">
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </x-form.select>

        </div>

        <div class="md:col-span-2">
            <x-form.select wire:model.defer="product.department_id" label="Departamanto">
                @foreach ($departments as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </x-form.select>

        </div>
    </x-form.grid>
</x-form.section-form>

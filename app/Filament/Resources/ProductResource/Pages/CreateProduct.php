<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    protected ?string $subheading = 'Luego de crear el producto podras agregar mas informacion como imagenes, especificaciones etc';

    protected function handleRecordCreation(array $data): Model
    {
        // produc parent

        $parent_product = static::getModel()::create([
            ...$data,
            'img' => null,
            'thumb' => null
        ]);

        $data['parent_id'] = $parent_product->id;

        $parent_product_id = Str::padLeft($data['parent_id'], 4, '0');

        $data['ref'] = $parent_product_id . '-' . Str::padLeft($data['color_id'], 3, '0');

        return static::getModel()::create($data);
    }
}

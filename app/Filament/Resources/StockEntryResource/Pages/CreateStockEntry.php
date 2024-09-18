<?php

namespace App\Filament\Resources\StockEntryResource\Pages;

use App\Filament\Resources\StockEntryResource;
use App\Models\Sku;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStockEntry extends CreateRecord
{
    protected static string $resource = StockEntryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $sku = Sku::where('product_id', $data['product_id'])
            ->where('size_id', $data['size_id'])->firstOrNew();

        $sku->increment('stock', $data['quantity']);

        $data['sku_id'] = $sku->id;

        $data['user_id'] = auth()->id();

        unset($data['product_id']);
        unset($data['size_id']);
        return $data;
    }
}

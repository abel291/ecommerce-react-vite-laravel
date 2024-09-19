<?php

namespace App\Filament\Resources\StockAdjustmentResource\Pages;

use App\Filament\Resources\StockAdjustmentResource;
use App\Models\Sku;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStockAdjustment extends CreateRecord
{
    protected static string $resource = StockAdjustmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // dd($data);
        $sku = Sku::firstOrNew(
            [
                'product_id' => $data['product_id'],
                'size_id' => $data['size_id'],
            ],
        );
        $sku->stock = $data['final_stock'];
        $sku->save();

        $data['sku_id'] = $sku->id;
        $data['user_id'] = auth()->id();

        unset($data['final_stock']);
        unset($data['product_id']);
        unset($data['size_id']);



        return $data;
    }
}

<?php

namespace App\Filament\Resources\StockEntryResource\Pages;

use App\Filament\Resources\StockEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockEntry extends EditRecord
{
    protected static string $resource = StockEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

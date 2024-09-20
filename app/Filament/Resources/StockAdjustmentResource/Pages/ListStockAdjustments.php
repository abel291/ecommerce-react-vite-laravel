<?php

namespace App\Filament\Resources\StockAdjustmentResource\Pages;

use App\Enums\StockMovementOperationEnum;
use App\Filament\Resources\StockAdjustmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListStockAdjustments extends ListRecords
{
    protected static string $resource = StockAdjustmentResource::class;

    public function getTabs(): array
    {
        $orderStatus = [];
        foreach (StockMovementOperationEnum::cases() as $key => $case) {
            $orderStatus[$case->value] = Tab::make($case->getLabel())
                ->icon($case->getIcon())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', $case->value));
        }
        return [

            'all' => Tab::make('Todas las ventas'),
            ...$orderStatus
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderStatsOverview;
use Database\Seeders\OrderSeeder;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    public function getTabs(): array
    {
        $orderStatus = [];
        foreach (OrderStatusEnum::cases() as $key => $case) {
            $orderStatus[$case->value] = Tab::make($case->getLabel())
                ->icon($case->getIcon())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $case->value));
        }
        return [

            'all' => Tab::make('Todas las ventas'),
            ...$orderStatus
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

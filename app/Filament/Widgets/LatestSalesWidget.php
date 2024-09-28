<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\SaleResource;
use App\Filament\Resources\SaleResource\Pages\ViewSale;
use App\Models\Order;
use App\Models\Sale;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestSalesWidget extends BaseWidget
{
    protected static bool $isLazy = false;
    public static function canView(): bool
    {
        return true;
    }
    protected static ?int $sort = 10;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Ultimas Ventas';
    public function table(Table $table): Table
    {

        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return $table
            ->query(Order::query()
                ->with('payment')
                ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                ->withCount('order_products')->latest())
            ->defaultPaginationPageOption(8)
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('code')->label('Codigo'),
                // TextColumn::make('location.nameType')->label('Ubicacion'),
                TextColumn::make('data.user.name')->label('Cliente'),
                TextColumn::make('order_products_count')->label('Productos'),
                TextColumn::make('status')->label('Estado')->badge(),
                TextColumn::make('payment.method')->label('Tipo de pago')->badge(),
                TextColumn::make('total')->label('Total')->money(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')->label('Ver orden completa')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record->id]))
            ]);
    }
}

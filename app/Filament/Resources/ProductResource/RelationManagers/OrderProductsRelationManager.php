<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\OrderProduct;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'order_products';

    protected static ?string $title = 'Ventas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('order.code')->label('Codigo de venta'),
                // Tables\Columns\TextColumn::make('name')->wrap()->label('Nombre'),
                // Tables\Columns\TextColumn::make('color')->label('Color'),
                Tables\Columns\TextColumn::make('size')->label('Tamaño'),
                Tables\Columns\TextColumn::make('price')->money()->label('Precio'),
                Tables\Columns\TextColumn::make('quantity')->label('Cantidad'),
                Tables\Columns\TextColumn::make('total')->money()->label('Total'),
                Tables\Columns\TextColumn::make('order.status')->badge()->label('Estado'),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de la venta')->sortable()->dateTime()->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                // SelectFilter::make('size')
                //     ->options(function ($livewire) {
                //         dd($livewire->ownerRecord);
                //     }),
                OrderResource::filtersDate()
            ])
            ->headerActions([])
            ->actions([
                Action::make('view-order-detail')
                    ->url(fn(OrderProduct $record): string => OrderResource::getUrl('view', ['record' => $record->order_id]))
                    ->label('Ver Venta completa')->color('info'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

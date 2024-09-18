<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\StockEntryResource;
use App\Models\Product;
use App\Models\Sku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkusRelationManager extends RelationManager
{
    protected static string $relationship = 'skus';

    protected static ?string $title = 'Stock';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('size.name')->placeholder('Sin Talla')->label('Tamaño'),
                Tables\Columns\TextColumn::make('stock')->numeric(),
                Tables\Columns\TextColumn::make('order_products_count')->counts('order_products')->label('Ventas'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('view-order-detail')
                    ->url(fn(Sku $record): string => StockEntryResource::getUrl('index', [
                        'record' => $record->order_id,
                        'tableFilters[sku_id][value]' => $record->id
                    ]))
                    ->label('Historial de entrada de mercancia')->color('info'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

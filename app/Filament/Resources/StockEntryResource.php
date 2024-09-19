<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockEntryResource\Pages;
use App\Filament\Resources\StockEntryResource\RelationManagers;
use App\Models\Department;
use App\Models\Product;
use App\Models\Size;
use App\Models\Sku;
use App\Models\StockEntry;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockEntryResource extends Resource
{
    protected static ?string $model = StockEntry::class;

    public static ?string $label = 'Entrada de stock';
    protected static ?string $pluralModelLabel = 'Entrada de stock';
    protected static ?string $navigationGroup = 'Stock';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->getSearchResultsUsing(function (string $search): array {
                        return Product::select('id', 'name', 'ref', 'color_id')
                            ->with('color:id,name')
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('ref', 'like', "%{$search}%")
                            ->variant()
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(function ($product) {
                                return [$product->id => "{$product->ref} {$product->name} Color: {$product->color->name}"];
                            })->toArray();
                    })
                    ->getOptionLabelUsing(fn($value): ?string => Product::find($value)?->name)
                    ->searchable()
                    ->columnSpan(4)
                    ->label('Producto'),

                Select::make('size_id')
                    ->options(Size::pluck('name', 'id')->toArray())
                    ->columnSpan(2)
                    ->label('Tamaño'),

                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->minValue(1)
                    ->default(1)
                    ->columnSpan(1)
                    ->numeric()
                    ->label('Cantidad'),

                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->columnSpan(1)
                    ->label('Costo'),

                Forms\Components\Textarea::make('note')
                    ->columnSpan(4)
                    ->label('Nota'),

            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with('sku.product:id,name,slug,thumb,ref,color_id', 'sku.size:id,name', 'sku.product.color');
            })
            ->columns([
                Tables\Columns\ImageColumn::make('sku.product.thumb')
                    ->size(40)->circular()->label('Imagen'),
                Tables\Columns\TextColumn::make('sku.product.name')
                    ->url(fn($record) => route('product', [$record->sku->product->slug, $record->sku->product->ref]))
                    ->openUrlInNewTab()

                    ->label('Nombre')
                    ->description(fn($record) => ("Tamaño " . $record->sku->size->name . " - Color " . $record->sku->product->color->name)),
                Tables\Columns\TextColumn::make('sku.product.ref')
                    ->wrap()
                    ->badge()
                    ->color('gray')

                    ->label('Ref'),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()

                    ->label('Cantidad'),
                Tables\Columns\TextColumn::make('cost')
                    ->money()

                    ->label('Costo'),
                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
                ...DepartmentResource::dateCreatedTable()
            ])
            ->filters([
                SelectFilter::make('sku_id')
                    ->label('Producto')
                    ->getSearchResultsUsing(function (string $search): array {
                        return Sku::with('size:id,name')->withWhereHas('product', function ($query) use ($search) {
                            $query
                                ->select('id', 'name', 'ref', 'color_id')->with('color:id,name')->variant()
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('ref', 'like', "%{$search}%");
                        })
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(function ($sku) {
                                return [$sku->id => "{$sku->product->ref} {$sku->product->name} - Color {$sku->product->color->name} - Talla {$sku->size->name}"];
                            })->toArray();
                    })
                    ->getOptionLabelUsing(fn($value): ?string => Sku::find($value)?->product->name)
                    ->columnSpan(3)
                    ->searchable()

                // SelectFilter::make('sku_id')
                //     ->relationship(
                //         name: 'sku',
                //         modifyQueryUsing: fn(Builder $query) => $query->with('product:id,name,color_id', 'product.color:id,name', 'size:id,name'),
                //         titleAttribute: 'id'
                //     )
                //     ->getOptionLabelFromRecordUsing(function (Model $record) {
                //         return "{$record->product->ref} {$record->product->name} {$record->product->color->name} {$record->size->name}";
                //     })
                //     ->optionsLimit(10)
                //     ->columnSpan(4)
                //     ->searchable(),
                // SelectFilter::make('sku_id')
                //     ->relationship('sku', 'id')
                //     ->searchable()
                //     ->label('Producto'),
                // SelectFilter::make('size')
                //     ->relationship('sku.size', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->label('Tamaño'),
                // SelectFilter::make('color')
                //     ->relationship('sku.product.color', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->label('Color')
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockEntries::route('/'),
            // 'create' => Pages\CreateStockEntry::route('/create'),
            // 'edit' => Pages\EditStockEntry::route('/{record}/edit'),
        ];
    }
}

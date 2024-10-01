<?php

namespace App\Filament\Resources;

use App\Enums\StockMovementOperationEnum;
use App\Filament\Resources\StockAdjustmentResource\Pages;
use App\Filament\Resources\StockAdjustmentResource\RelationManagers;
use App\Models\Product;
use App\Models\Size;
use App\Models\Sku;
use App\Models\StockAdjustment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockAdjustmentResource extends Resource
{
    protected static ?string $model = StockAdjustment::class;

    public static ?string $label = 'Ajuste de stock';
    protected static ?string $pluralModelLabel = 'Ajuste de stock';
    protected static ?string $navigationGroup = 'Stock';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
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
                    ->getOptionLabelUsing(fn($value): ?string => Sku::find($value)?->product->name)
                    ->searchable()

                    ->columnSpan(3)
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, $state, $context) {
                        self::changeProductSize($get, $set);
                    })
                    ->label('Producto'),

                Select::make('size_id')
                    ->options(Size::pluck('name', 'id')->toArray())
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, $state, $context) {
                        self::changeProductSize($get, $set);
                    })
                    ->searchable()
                    ->preload(true)
                    ->label('Tamaño'),

                Forms\Components\TextInput::make('quantity')
                    ->label('Cantidad')
                    ->minValue(1)
                    ->maxValue(function ($get) {
                        if ($get('type') == 'subtraction')
                            return $get('current_stock');
                    })
                    ->placeholder(0)
                    ->required()
                    ->live(debounce: 400)
                    ->afterStateUpdated(function (Set $set, Get $get, ) {
                        self::changeFormQuantity($get, $set);
                    })
                    ->numeric(),
                Forms\Components\Select::make('type')

                    ->options(StockMovementOperationEnum::class)
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, ) {
                        self::changeFormQuantity($get, $set);
                    })
                    ->default('addition')
                    ->label('Tipo de operacion')
                    ->required(),

                Forms\Components\TextInput::make('current_stock')
                    ->label('Stock Actual')
                    ->placeholder(0)
                    ->disabled(),

                Forms\Components\TextInput::make('final_stock')
                    ->label('Stock Final')
                    ->disabled()
                    ->placeholder(0)
                    ->dehydrated(),

                Forms\Components\Textarea::make('note')
                    ->required()
                    ->placeholder('Razon del Ajuste')
                    ->label('Nota')
                    ->columnSpanFull(),

            ]);
    }
    public static function changeProductSize($get, $set)
    {
        if ($get('product_id') && $get('size_id')) {
            $sku = Sku::where('product_id', $get('product_id'))
                ->where('size_id', $get('size_id'))
                ->first();
            // dd($sku);
            $set('current_stock', $sku ? $sku->stock : 0);
            // self::changeFormQuantity($get, $set);
        } else {
            $set('current_stock', null);
        }
        $set('quantity', null);
        $set('final_stock', null);
    }

    public static function changeFormQuantity($get, $set)
    {

        if ($get('quantity') && $get('type')) {

            $final_stock = match ($get('type')) {
                'addition' => $get('current_stock') + $get('quantity'),
                'subtraction' => $get('current_stock') - $get('quantity'),
            };
            $set('final_stock', $final_stock);
        } else {
            // $set('current_stock', null);
            $set('quantity', null);
            $set('final_stock', null);
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with('sku.product:id,name,slug,thumb,ref,color_id', 'sku.size:id,name', 'sku.product.color:id,name');
            })
            ->columns([
                Tables\Columns\ImageColumn::make('sku.product.thumb')
                    ->size(40)->circular()->label('Imagen'),
                Tables\Columns\TextColumn::make('sku.product.name')
                    ->wrap()
                    ->url(fn($record) => route('product', [$record->sku->product->slug, $record->sku->product->ref]))
                    ->openUrlInNewTab()
                    ->label('Nombre')
                    ->description(fn($record) => ("Tamaño " . $record->sku->size->name . " - Color " . $record->sku->product->color->name))
                    ->formatStateUsing(fn(StockAdjustment $record): string => "{$record->sku->product->ref} {$record->sku->product->name}"),

                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->label('Cantidad'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->label('Tipo de operacion'),
                Tables\Columns\TextColumn::make('sku.stock')
                    ->numeric()
                    ->label('Stock Actual'),

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
            'index' => Pages\ListStockAdjustments::route('/'),
            'create' => Pages\CreateStockAdjustment::route('/create'),
            // 'edit' => Pages\EditStockAdjustment::route('/{record}/edit'),
        ];
    }
}

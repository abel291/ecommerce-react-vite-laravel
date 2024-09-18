<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Color;
use App\Models\Product;
use App\Services\ProductService;
use Filament\Actions\Contracts\ReplicatesRecords;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static ?string $label = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationGroup = 'Catalogo';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';


    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::variant()->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Set $set, $state, $context) {
                        if ($context === 'edit') {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    })
                    ->maxLength(255)
                    ->required()
                    ->columnSpan(4)
                    ->label('Nombre'),
                Forms\Components\TextInput::make('ref')
                    ->maxLength(255)
                    ->columnSpan(2)
                    ->disabled()
                    ->helperText('Se genera automaticamente al guarda')
                    ->label('Referencia'),

                Forms\Components\TextInput::make('slug')
                    ->maxLength(255)
                    ->required()
                    ->prefix(url('/product') . '/')
                    ->suffix(fn(Get $get) => "/ref/{$get('ref')}")
                    ->columnSpan(4),

                Forms\Components\Select::make('color_id')
                    ->relationship('color', 'name')
                    ->required()
                    ->columnSpan(2)
                    ->disableOptionWhen(function (Product $record, string $value) {
                        $colors_id = $record->product->variants()->whereNot('color_id', $record->color_id)->pluck('color_id')->toArray();
                        return in_array($value, $colors_id);
                    })
                    ->preload()
                    ->suffixIcon('heroicon-m-swatch')
                    ->suffixIconColor('info')
                    ->createOptionForm(ColorResource::formColor())
                    ->label('Color'),

                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required()
                    ->columnSpan(2)
                    ->label('Departamento'),

                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->columnSpan(2)
                    ->label('Categoria'),

                Forms\Components\TextInput::make('max_quantity')
                    ->required()
                    ->numeric()
                    ->label('Cantidad maxima a comprar')
                    ->columnSpan(2)
                    ->default(1),

                Forms\Components\Toggle::make('featured')
                    ->required()
                    ->columnSpan(2)
                    ->label('Destacado'),

                Forms\Components\Toggle::make('active')
                    ->required()
                    ->columnSpan(2)
                    ->label('Visible'),


                Forms\Components\Textarea::make('entry')
                    ->required()
                    ->columnSpanFull()
                    // ->maxLength(255)
                    ->label('Pequeña Descripcion'),

                Forms\Components\RichEditor::make('description')
                    ->disableToolbarButtons(['attachFiles'])
                    ->columnSpanFull()
                    ->label('Descripcion Larga'),

                Forms\Components\FileUpload::make('img')->directory('/img/products')
                    ->columnSpan(3)
                    ->required()
                    ->label('Imagen pequeña'),

                Forms\Components\FileUpload::make('thumb')->directory('/img/products/thumb')
                    ->columnSpan(3)
                    ->required()
                    ->label('Imagen'),

                self::formPrice(),


                Grid::make(2),











            ])
            ->columns(6);
    }
    public static function formPrice()
    {
        return Forms\Components\Fieldset::make('Precio')
            ->columns(4)
            ->schema([

                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()

                    ->placeholder(0)
                    ->prefix('$')
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        self::changePrice($set, $get);
                    })
                    ->label('Precio'),

                Forms\Components\TextInput::make('offer')
                    ->numeric()
                    ->maxValue(99)
                    ->minValue(0)
                    ->placeholder(0)
                    ->suffix('%')
                    ->disabled()
                    ->label('Descuento'),

                Forms\Components\TextInput::make('old_price')
                    ->numeric()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        self::changePrice($set, $get);
                    })
                    ->prefix('$')
                    ->placeholder(0)
                    ->minValue(fn(Get $get, $state) => $state ? $get('price') : 0)
                    ->label('Precio de comparacion'),

            ]);
    }
    public static function changePrice($set, $get)
    {

        if (!$get('old_price')) {
            return;
        }
        if ($get('price') > $get('old_price')) {
            Notification::make()
                ->title('El precio de comparacion no puede ser menor al precio estandar')
                ->danger()
                ->send();
            return;
        }

        $offer = ($get('price') / $get('old_price')) * 100;
        $set('offer', round($offer));
    }
    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->variant()->withSum('skus', 'stock')->with('color');
            })

            ->columns([
                Tables\Columns\ImageColumn::make('thumb')
                    ->width(40)->label('Imagen'),

                Tables\Columns\TextColumn::make('name')
                    ->url(fn($record) => route('product', [$record->slug, $record->ref]))
                    ->openUrlInNewTab()
                    ->wrap(true)
                    ->description(fn($record): string => "ref " . $record->ref)
                    ->searchable()
                    ->label('Nombre'),

                Tables\Columns\TextColumn::make('color.name')
                    ->searchable()
                    ->label('Color'),

                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable()
                    ->label('Precio'),

                Tables\Columns\TextColumn::make(name: 'skus_sum_stock')
                    ->numeric()
                    ->sortable()
                    ->label('Disponible'),

                Tables\Columns\ToggleColumn::make('featured')
                    ->label('Destacado'),

                Tables\Columns\ToggleColumn::make('active')
                    ->label('Visible'),

                ...DepartmentResource::dateCreatedTable()
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('type', 'product'),)
                    ->preload()
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->icon('heroicon-o-pencil-square')->color('info'),
                    Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash'),
                    Action::make('product-relations')
                        ->url(fn(Product $record): string => ProductResource::getUrl('product-relations', ['record' => $record->id]))
                        ->label('Datos relacionados')->color('gray')->icon('heroicon-o-squares-2x2'),


                    ReplicateAction::make('replicate_product')
                        ->excludeAttributes(['thumb', 'img', 'active', 'skus_sum_stock', 'new_color_id'])
                        ->requiresConfirmation()
                        ->modalDescription('Se creara una replica de este producto pero sin las imagenes y sin el color')
                        ->modalSubmitActionLabel('Crear Replica')
                        ->modalIcon('heroicon-o-exclamation-circle')
                        ->beforeReplicaSaved(function (Product $replica, $data): void {
                            // $replica->color_id = $data['new_color_id'];
                            $replica->active = false;
                            $replica->featured = false;
                            $replica->ref = ProductService::generateRef($replica->parent_id, $replica->color_id);
                        })
                        ->fillForm(fn(Product $record): array => [
                            'color_id' => null,
                        ])
                        ->form([
                            Grid::make(5)->schema([
                                Select::make('color_id')
                                    ->label('Color')
                                    ->required()
                                    ->options(Color::query()->pluck('name', 'id'))
                                    ->disableOptionWhen(function (Product $record, string $value) {
                                        $colors_id = $record->product->variants()->pluck('color_id')->toArray();
                                        return in_array($value, $colors_id);
                                    })
                                    ->columnSpan(3),
                            ])
                        ])
                        ->successRedirectUrl(fn(Product $replica) => ProductResource::getUrl('edit', [$replica->id]))
                        ->label('Crear variante de color'),


                ])
                    ->link()
                    ->icon('heroicon-o-chevron-down')
                    ->label('Opciones'),

                Action::make('product-stock')
                    ->url(fn(Product $record): string => ProductResource::getUrl('product-stock', ['record' => $record->id]))
                    ->label('Stock')->color('gray'),


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         SpecificationsRelationManager::class
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'product-relations' => Pages\ViewProductRelationship::route('/product/{record}/relations'),
            'product-stock' => Pages\ViewProductStock::route('/{record}/skus'),
        ];
    }
}

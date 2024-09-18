<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SizeResource\Pages;
use App\Filament\Resources\SizeResource\RelationManagers;
use App\Models\Size;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SizeResource extends Resource
{
    protected static ?string $model = Size::class;
    protected static ?int $navigationSort = 4;
    public static ?string $label = 'Tamaño';
    protected static ?string $pluralModelLabel = 'Tamaños';
    protected static ?string $navigationGroup = 'Atributos';
    protected static ?string $navigationIcon = 'heroicon-o-tag';

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
                    })->label('Nombre'),
                Forms\Components\Hidden::make('slug')
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre')
                    ->searchable()->sortable()->placeholder('Sin Talla'),

                Tables\Columns\TextColumn::make('products_count')->counts('products')->searchable()
                    ->label('N° Productos')->sortable(),

                ...DepartmentResource::dateCreatedTable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth(MaxWidth::Medium),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSizes::route('/'),
            // 'create' => Pages\CreateSize::route('/create'),
            // 'edit' => Pages\EditSize::route('/{record}/edit'),
        ];
    }
}

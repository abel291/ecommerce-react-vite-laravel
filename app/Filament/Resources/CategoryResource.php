<?php

namespace App\Filament\Resources;

use App\Enums\CategoryTypeEnum;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    public static ?string $label = 'Categoria';
    protected static ?string $pluralModelLabel = 'Categorias';
    protected static ?string $navigationGroup = 'Catalogo';
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
                DepartmentResource::slugForm(prefixRouteName: 'home'),
                Forms\Components\Toggle::make('active')
                    ->required()->label('Visible'),
                Forms\Components\Toggle::make('in_home')->inline(false)
                    ->required()->label('Aparece en el home'),
                // Forms\Components\TextInput::make('slug')
                //     ->required(),
                Forms\Components\FileUpload::make('img')->directory('img/categories')->label('Imagen'),
                Forms\Components\TextInput::make('entry')->columnSpanFull()->label('Pequeña descripcion'),

                Forms\Components\Select::make('type')->options(CategoryTypeEnum::class)
                    ->default(CategoryTypeEnum::PRODUCT)
                    ->required()->label('Tipo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img')
                    ->size(50)
                    ->square()
                    ->searchable()
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->label('Nombre'),
                // Tables\Columns\TextColumn::make('slug')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('banner')
                //     ->searchable(),

                // Tables\Columns\TextColumn::make('entry')
                //     ->searchable(),
                Tables\Columns\ToggleColumn::make('active')->label('Visible'),
                Tables\Columns\ToggleColumn::make('in_home')->label('Aparece en el home'),
                Tables\Columns\TextColumn::make('type')->badge()->label('Tipo'),
                ...DepartmentResource::dateCreatedTable()
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(CategoryTypeEnum::class)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            // 'create' => Pages\CreateCategory::route('/create'),
            // 'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

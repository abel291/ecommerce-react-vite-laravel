<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers;
use App\Models\Department;
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

class DepartmentResource extends Resource
{
    protected static ?int $navigationSort = 1;
    protected static ?string $model = Department::class;

    public static ?string $label = 'Departamento';
    protected static ?string $pluralModelLabel = 'Departamentos';
    protected static ?string $navigationGroup = 'Catalogo';
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

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
                self::slugForm(prefixRouteName: 'department'),
                Forms\Components\FileUpload::make('img')
                    ->directory('img/departments')
                    ->required()->label('Imagen'),
                Forms\Components\Textarea::make('entry')
                    ->columnSpanFull()
                    ->label('Pequeña descripcion'),
                Forms\Components\Toggle::make('active')
                    ->required()
                    ->label('Visible'),

                self::metasForm()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img')->width(100)->label('Imagen'),
                Tables\Columns\TextColumn::make('name')->label('Nombre')
                    ->description(fn($record) => $record->slug)
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->formatStateUsing(fn($record) => route('department', $record->slug))
                    ->url(fn($record) => route('department', $record->slug))
                    ->openUrlInNewTab(),

                Tables\Columns\ToggleColumn::make('active')->label('Visible'),

                Tables\Columns\TextColumn::make('products_count')->counts([
                    'products' => fn(Builder $query) => $query->active()->variant(),
                ])->label('Productos'),

                ...self::dateCreatedTable()
            ])
            ->filters([
                //
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
    public static function dateCreatedTable()
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->description(fn($state) => $state->format('h:i A'))
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->label('Fecha de creacion'),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->description(fn($state) => $state->format('h:i A'))
                ->toggleable(isToggledHiddenByDefault: false)
                ->label('Ultima modificacion'),
        ];
    }
    public static function slugForm($prefixRouteName = 'home')
    {
        return Forms\Components\TextInput::make('slug')
            ->prefix(url(route($prefixRouteName, '')) . '/')
            ->required()
            ->maxLength(255)
            ->rules(['alpha_dash'])
            ->unique(ignoreRecord: true)
            ->label('Url');
    }
    public static function metasForm()
    {
        return Forms\Components\Fieldset::make('MetaTags')
            ->relationship('metaTag')
            ->schema([
                Forms\Components\TextInput::make('meta_title')

                    ->required()
                    ->maxLength(255)
                    ->label('Meta titulo'),
                Forms\Components\Textarea::make('meta_description')
                    ->required()
                    ->maxLength(255)
                    ->label('Meta descripcion'),
            ])->columns(1);
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
            'index' => Pages\ListDepartments::route('/'),
            // 'create' => Pages\CreateDepartment::route('/create'),
            // 'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}

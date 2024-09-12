<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Imagenes';
    protected static ?string $icon = 'heroicon-m-photo';


    public function isReadOnly(): bool
    {
        return false;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Titulo'),
                Forms\Components\TextInput::make('alt')
                    ->required()
                    ->maxLength(255)
                    ->label('Alt'),
                Forms\Components\TextInput::make('sort')
                    ->numeric()
                    ->required()
                    ->maxLength(255)
                    ->label('Orden'),
                Forms\Components\FileUpload::make('img')
                    ->directory('/img/products')
                    ->required()
                    ->label('Imagen')

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('img')
            ->columns([
                // Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('img')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->size(40)->label('Imagen'),
                Tables\Columns\TextColumn::make('title')->label('Titulo'),
                Tables\Columns\ToggleColumn::make('active')->label('Visible'),
                Tables\Columns\TextColumn::make('sort')->label('Orden'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if ($data['img'][0] != '/') {
                            $data['img'] = '/' . $data['img'];
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->mutateFormDataUsing(function (array $data): array {
                    if ($data['img'][0] != '/') {
                        $data['img'] = '/' . $data['img'];
                    }
                    return $data;
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort', 'asc');
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    public static ?string $label = 'Post';
    protected static ?string $pluralModelLabel = 'Posts';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 17;
    public static function form(Form $form): Form
    {
        return $form
            ->columns(6)
            ->schema([
                Forms\Components\TextInput::make('title')
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
                    ->columnSpan(3)
                    ->label('Nombre'),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255)
                    ->required()
                    ->prefix(url('/post') . '/')
                    ->columnSpan(3),
                Forms\Components\Textarea::make('entry')->label('Descripción pequeña')
                    ->columnSpan(5)
                    ->required()
                ,
                Forms\Components\Toggle::make('active')->label('Activo')
                    ->required(),
                Forms\Components\RichEditor::make('desc')
                    ->disableToolbarButtons(['attachFiles'])
                    ->columnSpanFull()
                    ->label('Descripcion Larga'),

                Forms\Components\FileUpload::make('img')->directory('/img/posts')
                    ->columnSpan(3)
                    ->required()
                    ->label('Imagen pequeña'),

                Forms\Components\FileUpload::make('thum')->directory('/img/posts/thumb')
                    ->columnSpan(3)
                    ->required()
                    ->label('Imagen'),

                Forms\Components\Select::make('author_id')
                    ->columnSpan(2)
                    ->relationship('author', 'name'),
                Forms\Components\Select::make('category_id')
                    ->columnSpan(2)
                    ->relationship(
                        'category',
                        'name',
                        modifyQueryUsing: fn(Builder $query) => $query->where('type', 'blog'),
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thum')
                    ->width(40)->label('Imagen'),
                Tables\Columns\TextColumn::make('title')
                    ->wrap()
                    ->url(fn($record) => route('post', [$record->slug]))
                    ->openUrlInNewTab()
                    ->searchable(),

                Tables\Columns\TextColumn::make('author.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active')->label('Visible'),
                ...DepartmentResource::dateCreatedTable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}

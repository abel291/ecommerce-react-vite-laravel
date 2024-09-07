<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static ?string $label = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';
    protected static ?string $navigationGroup = 'Clientes';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    public static function mutateDataPassword(array $data): array
    {
        if (array_key_exists('password', $data) || filled($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        unset($data["password_confirmation"]);
        return $data;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()->label('Nombre'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->tel()->label('Telefono'),
                Forms\Components\TextInput::make('country')->label('Pais'),
                Forms\Components\TextInput::make('city')->label('Ciudad'),
                Forms\Components\TextInput::make('address')
                    ->columnSpanFull()->label('Direccion'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->nullable()
                    ->required(fn(string $context): bool => $context === 'create')
                    ->rule(Password::default())
                    ->label('Contraseña'),

                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->same('password')
                    ->requiredWith('password')
                    ->rule(Password::default())
                    ->label('Confirmar Contraseña'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(fn($record) => $record->email)
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('city')
                    ->description(fn($record) => $record->country)
                    ->searchable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')->label('Num de compras'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('view-orders')
                    ->url(fn(User $record): string => UserResource::getUrl('view-orders', ['record' => $record->id]))
                    ->label('Ver ordernes')->color('gray'),

                Tables\Actions\EditAction::make()->mutateFormDataUsing(function (array $data): array {
                    return self::mutateDataPassword($data);
                }),

                Tables\Actions\DeleteAction::make(),

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
    //         RelationManagers\OrdersRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
            // 'view' => Pages\ViewUser::route('/{record}'),
            'view-orders' => Pages\ViewUserOrders::route('/{record}/orders'),
        ];
    }
}

<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                TextColumn::make('code')->label('Numero')->searchable(),
                TextColumn::make('data.user.name')->wrap()->searchable(),
                TextColumn::make('order_products_count')->label('Productos')->counts('order_products'),
                TextColumn::make('shipping')->label('Costo de envio')->numeric()->money(),
                TextColumn::make('total')->label('Precio Total')->numeric()->money(),
                TextColumn::make('status')->badge(),
                TextColumn::make('payment.method')->label('Tipo de pago')->badge(),
                TextColumn::make('created_at')->label('Fecha de la venta')
                    ->sortable()->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('order-view')
                    ->url(fn(Order $record): string => 123)
                    ->label('Ver ordernes')->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

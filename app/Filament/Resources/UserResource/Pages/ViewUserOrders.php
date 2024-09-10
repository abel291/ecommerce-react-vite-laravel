<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUserOrders extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return "Ver ordenes de {$this->record->name}";
    }

    public function getRelationManagers(): array
    {
        return [
            OrdersRelationManager::class,
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist

            ->schema([
                TextEntry::make('name')->label('Nombre'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('phone')->label('Telefono'),
                TextEntry::make('country')->label('Pais'),
                TextEntry::make('city')->label('Ciudad'),
                TextEntry::make('address')->columnSpanFull()->label('Direccion'),
            ])->columns(3);
    }
}

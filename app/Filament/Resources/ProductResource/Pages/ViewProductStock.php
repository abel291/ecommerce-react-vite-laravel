<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\RelationManagers\OrderProductsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\SkusRelationManager;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewProductStock extends ViewRecord
{
    protected static string $resource = ProductResource::class;



    public function getBreadcrumb(): string
    {
        return 'Tamaños';
    }
    public function getTitle(): string
    {
        return "{$this->record->name}";
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist

            ->schema([
                ImageEntry::make('thumb')->label('Imagen Principal')->circular()->height(80),
                TextEntry::make('name')->label('Nombre')->columnSpan(2),
                TextEntry::make('ref')->label('Referencia'),
                TextEntry::make('color.name')->label('Color'),
                TextEntry::make('price')->money()->label('Precio'),
            ])->columns(8);
    }

    public function getRelationManagers(): array
    {
        return [
            SkusRelationManager::class,
            OrderProductsRelationManager::class
        ];
    }
}

<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\SpecificationsRelationManager;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewProductRelationship extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function getBreadcrumb(): string
    {
        return 'Relaciones';
    }
    public function getTitle(): string
    {
        return "{$this->record->name}";
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist

            ->schema([
                ImageEntry::make('thumb')->label('Imagen Principal'),
                TextEntry::make('name')->label('Nombre')->columnSpan(2),
                TextEntry::make('ref')->label('Referencia'),
                TextEntry::make('color.name')->label('Color'),
                TextEntry::make('price')->money()->label('Precio'),
            ])->columns(8);
    }

    public function getRelationManagers(): array
    {
        return [
            ImagesRelationManager::class,
            SpecificationsRelationManager::class,

        ];
    }
}

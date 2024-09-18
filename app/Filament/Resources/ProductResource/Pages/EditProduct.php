<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['img'] && $data['img'][0] != '/') {
            $data['img'] = '/' . $data['img'];
        }
        if ($data['thumb'] && $data['thumb'][0] != '/') {
            $data['thumb'] = '/' . $data['thumb'];
        }

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

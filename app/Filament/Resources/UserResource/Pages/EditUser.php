<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    // public function mutateFormDataBeforeSave(array $data): array
    // {
    //     if (array_key_exists('password', $data) || filled($data['password'])) {
    //         $this->record->password = Hash::make($data['password']);
    //     }
    //     unset($data["password_confirmation "]);
    //     return $data;
    // }
}

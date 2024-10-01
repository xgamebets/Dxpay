<?php

namespace App\Filament\Resources\CredenciaisResource\Pages;

use App\Filament\Resources\CredenciaisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCredenciais extends EditRecord
{
    protected static string $resource = CredenciaisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

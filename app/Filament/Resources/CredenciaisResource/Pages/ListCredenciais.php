<?php

namespace App\Filament\Resources\CredenciaisResource\Pages;

use App\Filament\Resources\CredenciaisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCredenciais extends ListRecords
{
    protected static string $resource = CredenciaisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\GerenciamentoResource\Pages;

use App\Filament\Resources\GerenciamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGerenciamentos extends ListRecords
{
    protected static string $resource = GerenciamentoResource::class;
     protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

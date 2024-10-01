<?php

namespace App\Filament\Resources\GerenciamentoResource\Pages;

use App\Filament\Resources\GerenciamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGerenciamento extends EditRecord
{
    protected static string $resource = GerenciamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

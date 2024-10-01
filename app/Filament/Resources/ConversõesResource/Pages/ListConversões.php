<?php

namespace App\Filament\Resources\ConversõesResource\Pages;

use App\Filament\Resources\ConversõesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConversões extends ListRecords
{
    protected static string $resource = ConversõesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

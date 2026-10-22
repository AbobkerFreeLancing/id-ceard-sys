<?php

namespace App\Filament\Resources\Chat\Messagings\Pages;

use App\Filament\Resources\Chat\Messagings\MessagingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMessagings extends ListRecords
{
    protected static string $resource = MessagingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

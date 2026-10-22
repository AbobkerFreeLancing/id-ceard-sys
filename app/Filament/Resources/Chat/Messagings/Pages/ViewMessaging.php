<?php

namespace App\Filament\Resources\Chat\Messagings\Pages;

use App\Filament\Resources\Chat\Messagings\MessagingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMessaging extends ViewRecord
{
    protected static string $resource = MessagingResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

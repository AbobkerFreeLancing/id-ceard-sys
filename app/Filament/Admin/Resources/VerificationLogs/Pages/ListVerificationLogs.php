<?php

namespace App\Filament\Admin\Resources\VerificationLogs\Pages;

use App\Filament\Admin\Resources\VerificationLogs\VerificationLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVerificationLogs extends ListRecords
{
    protected static string $resource = VerificationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

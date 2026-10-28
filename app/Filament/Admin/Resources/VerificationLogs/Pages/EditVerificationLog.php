<?php

namespace App\Filament\Admin\Resources\VerificationLogs\Pages;

use App\Filament\Admin\Resources\VerificationLogs\VerificationLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditVerificationLog extends EditRecord
{
    protected static string $resource = VerificationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

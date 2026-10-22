<?php

namespace App\Filament\Student\Resources\University\StudentIdentities\Pages;

use App\Filament\Student\Resources\University\StudentIdentities\StudentIdentityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentIdentity extends EditRecord
{
    protected static string $resource = StudentIdentityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

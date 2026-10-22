<?php

namespace App\Filament\Student\Resources\University\StudentIdentities\Pages;

use App\Filament\Student\Resources\University\StudentIdentities\StudentIdentityResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentIdentity extends ViewRecord
{
    protected static string $resource = StudentIdentityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

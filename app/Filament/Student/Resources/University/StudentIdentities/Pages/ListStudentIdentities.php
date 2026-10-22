<?php

namespace App\Filament\Student\Resources\University\StudentIdentities\Pages;

use App\Filament\Student\Resources\University\StudentIdentities\StudentIdentityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudentIdentities extends ListRecords
{
    protected static string $resource = StudentIdentityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

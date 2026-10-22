<?php

namespace App\Filament\Resources\University\AcademicYears\Pages;

use App\Filament\Resources\University\AcademicYears\AcademicYearResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAcademicYear extends ViewRecord
{
    protected static string $resource = AcademicYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

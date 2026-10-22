<?php

namespace App\Filament\Resources\University\AcademicYears\Pages;

use App\Filament\Resources\University\AcademicYears\AcademicYearResource;
use Filament\Resources\Pages\EditRecord;

class EditAcademicYear extends EditRecord
{
    protected static string $resource = AcademicYearResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

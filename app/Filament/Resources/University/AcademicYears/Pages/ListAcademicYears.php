<?php

namespace App\Filament\Resources\University\AcademicYears\Pages;

use App\Filament\Resources\University\AcademicYears\AcademicYearResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAcademicYears extends ListRecords
{
    protected static string $resource = AcademicYearResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

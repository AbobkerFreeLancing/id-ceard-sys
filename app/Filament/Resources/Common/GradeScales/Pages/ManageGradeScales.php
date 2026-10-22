<?php

namespace App\Filament\Resources\Common\GradeScales\Pages;

use App\Filament\Resources\Common\GradeScales\GradeScaleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageGradeScales extends ManageRecords
{
    protected static string $resource = GradeScaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make()->createAnother(false)->modalWidth('lg'),
        ];
    }
}

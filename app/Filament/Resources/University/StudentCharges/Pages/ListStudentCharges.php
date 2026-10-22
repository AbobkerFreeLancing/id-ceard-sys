<?php

namespace App\Filament\Resources\University\StudentCharges\Pages;

use App\Filament\Resources\University\StudentCharges\StudentChargeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudentCharges extends ListRecords
{
    protected static string $resource = StudentChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make()->hidden(),
        ];
    }
}

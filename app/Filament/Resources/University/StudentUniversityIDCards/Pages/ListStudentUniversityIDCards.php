<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards\Pages;

use App\Filament\Resources\University\StudentUniversityIDCards\StudentUniversityIDCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudentUniversityIDCards extends ListRecords
{
    protected static string $resource = StudentUniversityIDCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

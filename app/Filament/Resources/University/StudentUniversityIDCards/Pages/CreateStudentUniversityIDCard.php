<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards\Pages;

use App\Filament\Resources\University\StudentUniversityIDCards\StudentUniversityIDCardResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentUniversityIDCard extends CreateRecord
{
    protected static string $resource = StudentUniversityIDCardResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}

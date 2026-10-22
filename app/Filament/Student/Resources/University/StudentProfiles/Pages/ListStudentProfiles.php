<?php

namespace App\Filament\Student\Resources\University\StudentProfiles\Pages;

use App\Filament\Student\Resources\University\StudentProfiles\StudentProfileResource;
use Filament\Resources\Pages\ListRecords;

class ListStudentProfiles extends ListRecords
{
    protected static string $resource = StudentProfileResource::class;

    public function mount(): void
    {
        $this->redirect(StudentProfileResource::getUrl('edit', [student()->id]));
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

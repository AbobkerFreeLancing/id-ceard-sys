<?php

namespace App\Filament\Resources\University\StudentCharges\Pages;

use App\Filament\Resources\University\StudentCharges\StudentChargeResource;
use App\Filament\Resources\University\Students\StudentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewStudentCharge extends ViewRecord
{
    protected static string $resource = StudentChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_student_profile')
                ->label(__('backend.student_profile'))
                ->icon(Heroicon::UserCircle)
                ->color('gray')
                ->url(fn() => StudentResource::getUrl('view', [$this->getRecord()->student->id]), true),
        ];
    }
}

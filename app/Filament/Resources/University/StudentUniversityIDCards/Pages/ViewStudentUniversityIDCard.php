<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards\Pages;

use App\Filament\Resources\University\StudentUniversityIDCards\StudentUniversityIDCardResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentUniversityIDCard extends ViewRecord
{
    protected static string $resource = StudentUniversityIDCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label(__('backend.print'))
                ->icon('heroicon-o-printer')
                ->url(
                    fn(): string => StudentUniversityIDCardResource::getUrl('print', [
                        'record' => $this->getRecord(),
                    ]),
                ),
            EditAction::make(),
        ];
    }
}

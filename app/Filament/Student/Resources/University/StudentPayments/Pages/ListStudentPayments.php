<?php

namespace App\Filament\Student\Resources\University\StudentPayments\Pages;

use App\Filament\Student\Resources\University\StudentPayments\StudentPaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudentPayments extends ListRecords
{
    protected static string $resource = StudentPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            CreateAction::make()->hidden(),
        ];
    }
}

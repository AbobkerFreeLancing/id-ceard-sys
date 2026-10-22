<?php

namespace App\Filament\Student\Resources\University\StudentPayments\Pages;

use App\Filament\Student\Resources\University\StudentPayments\StudentPaymentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentPayment extends ViewRecord
{
    protected static string $resource = StudentPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

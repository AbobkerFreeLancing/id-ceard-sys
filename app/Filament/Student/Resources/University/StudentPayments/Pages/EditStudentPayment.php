<?php

namespace App\Filament\Student\Resources\University\StudentPayments\Pages;

use App\Filament\Student\Resources\University\StudentPayments\StudentPaymentResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentPayment extends EditRecord
{
    protected static string $resource = StudentPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
            ViewAction::make(),
        ];
    }
}

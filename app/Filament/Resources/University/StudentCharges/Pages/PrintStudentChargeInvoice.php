<?php

namespace App\Filament\Resources\University\StudentCharges\Pages;

use App\Filament\Resources\University\StudentCharges\StudentChargeResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class PrintStudentChargeInvoice extends ViewRecord
{
    protected static string $resource = StudentChargeResource::class;

    protected string $view = 'filament.resources.university.student-charges.pages.print-student-charge-invoice';

    public function getTitle(): string
    {
        return __('backend.student_charge_invoice');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label(__('backend.print'))
                ->icon('heroicon-o-printer')
                ->action(fn() => $this->js('window.print()')),
        ];
    }
}

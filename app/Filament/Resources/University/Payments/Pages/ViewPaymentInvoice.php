<?php

namespace App\Filament\Resources\University\Payments\Pages;

use App\Filament\Resources\University\Payments\PaymentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentInvoice extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected string $view = 'filament.resources.university.payments.pages.view-payment-invoice';

    public function getTitle(): string
    {
        return __('backend.payment_invoice');
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

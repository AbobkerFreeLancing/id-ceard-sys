<?php

namespace App\Filament\Resources\University\Payments\Pages;

use App\Filament\Resources\University\Payments\PaymentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\Url;

class PrintSelectedPayments extends Page
{
    protected static string $resource = PaymentResource::class;

    protected string $view = 'filament.resources.university.payments.pages.print-selected-payments';

    #[Url]
    public string $records = '';

    public function getTitle(): string
    {
        return __('backend.print_selected_payments');
    }

    protected function getViewData(): array
    {
        $recordIds = explode(',', $this->records);

        abort_if(
            $this->records === '' || collect($recordIds)->contains(fn(string $id): bool => ! ctype_digit($id)),
            404,
        );

        $recordIds = array_values(array_unique($recordIds));
        $recordPositions = array_flip($recordIds);
        $payments = PaymentResource::getEloquentQuery()
            ->with([
                'student',
                'charge.student',
                'charge.feeType',
                'charge.currency',
                'currency',
            ])
            ->whereKey($recordIds)
            ->get()
            ->sortBy(fn($payment): int => $recordPositions[(string) $payment->getKey()])
            ->values();

        abort_unless($payments->count() === count($recordIds), 404);

        return ['payments' => $payments];
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

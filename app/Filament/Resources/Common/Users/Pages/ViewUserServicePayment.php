<?php

namespace App\Filament\Resources\Common\Users\Pages;

use App\Filament\Resources\Common\Users\UserResource;
use Packages\Accounting\Models\UserPayment;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewUserServicePayment extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected string $view = 'bedaya:services::view-user-service-payment';

    public $payment;
    public $full_payment;

    public $user_payment;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();

        if (!$this->hasInfolist()) {
            $this->fillForm();
        }

        $this->user_payment = UserPayment::find($this->payment);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label(__('backend.print'))
                ->color('primary')
                ->icon('heroicon-o-printer')
                ->action(function () {
                    $this->js('window.print()');
                }),
        ];
    }
}

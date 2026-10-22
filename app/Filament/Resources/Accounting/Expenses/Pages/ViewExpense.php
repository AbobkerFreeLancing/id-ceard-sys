<?php

namespace App\Filament\Resources\Accounting\Expenses\Pages;

use App\Filament\Resources\Accounting\Expenses\ExpenseResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewExpense extends ViewRecord
{
    protected static string $resource = ExpenseResource::class;

    protected string $view = 'bedaya:accounting::view-expense';

    protected function getHeaderActions(): array
    {
        return [
             Action::make('print')
             ->label(__('backend.print'))
             ->color('warning')
             ->icon('heroicon-o-printer')
             ->action(function () {
                $this->js("window.print()");
            }),
        ];
    }
}


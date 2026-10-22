<?php

namespace App\Filament\Resources\Accounting\Expenses\Pages;

use App\Filament\Pages\ExpenseReportsPage;
use App\Filament\Resources\Accounting\Expenses\ExpenseResource;
use App\Filament\Resources\Accounting\ExpenseTypeResource;
use Packages\Accounting\Models\Expense;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Livewire\Component as Livewire;
use Filament\Resources\Pages\ListRecords;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->size('sm')
                ->icon('heroicon-o-plus')
                ->mutateDataUsing(function (array $data) {
                    $data['creator_id'] = auth()->id();
                    return $data;
                }),

            Action::make('expense_types')
                ->label(__('backend.expense_types'))
                ->size('sm')
                ->color('gray')
                ->icon('heroicon-o-rectangle-stack')
                ->url(function (Livewire $livewire) {
                    return ExpenseTypeResource::getUrl('index');
                }),

            Action::make('reports_page')
                ->label(__('backend.reports'))
                ->size('sm')
                ->color('success')
                ->url(function (Livewire $livewire) {
                    return ExpenseReportsPage::getUrl($livewire->getTableRecords()->items());
                })
                ->visible(Expense::count()),
        ];
    }
}

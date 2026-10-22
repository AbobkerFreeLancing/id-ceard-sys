<?php

namespace App\Filament\Resources\Accounting\ReceiptVouchers\Pages;

use App\Filament\Pages\ReceiptVoucherReportsPage;
use App\Filament\Resources\Accounting\ReceiptVouchers\ReceiptVoucherResource;
use Packages\Accounting\Models\ReceiptVoucher;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Livewire\Component as Livewire;
use Filament\Resources\Pages\ListRecords;

class ListReceiptVouchers extends ListRecords
{
    protected static string $resource = ReceiptVoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->size('sm'),

            Action::make('reports_page')
                ->label(__('backend.reports'))
                ->size('sm')
                ->color('success')
                ->url(function (Livewire $livewire) {
                    return ReceiptVoucherReportsPage::getUrl($livewire->getTableRecords()->items());
                })
                ->visible(ReceiptVoucher::count()),
        ];
    }
}

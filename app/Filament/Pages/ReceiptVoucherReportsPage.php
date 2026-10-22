<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Packages\Accounting\Models\Expense;
use Packages\Accounting\Models\ReceiptVoucher;

class ReceiptVoucherReportsPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected string $view = 'filament.pages.reports.receipt-vouchers-reports-page';

    public static function getNavigationLabel(): string
    {
        return __('backend.receipt_vouchers');
    }

    public function getTitle(): string
    {
        return __('backend.receipt_vouchers');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return __('backend.receipt_vouchers');
    }

    public $query;
    public $cleanQuery;
    public $reportList;
    public $reportListSum;

    public function mount()
    {
        $this->query = $_SERVER['QUERY_STRING'];
        $this->cleanQuery = explode('&', $this->query);

        // Report List Here
        $this->reportList = ReceiptVoucher::orderBy('created_at', 'DESC')->find($this->cleanQuery);
        $this->reportListSum = number_format($this->reportList->pluck('amount')->sum(), 2);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('do_print')
                ->label(__('backend.print'))
                ->color('warning')
                ->icon('heroicon-o-printer')
                ->size('sm')
                ->action(function () {
                    $this->js('window.print()');
                }),
        ];
    }
}

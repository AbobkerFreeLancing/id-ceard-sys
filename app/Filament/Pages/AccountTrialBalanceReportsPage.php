<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Packages\Accounting\Models\Account;

class AccountTrialBalanceReportsPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-scale';
    protected string $view = 'filament.pages.reports.account-trial-balance-report-page';
    protected static ?string $slug = 'trial-balance-report';

    public static function getNavigationLabel(): string
    {
        return __('backend.trial_balance');
    }

    public function getTitle(): string
    {
        return __('backend.trial_balance');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return __('backend.trial_balance');
    }

    public $query;
    public $cleanQuery;
    public $reportList;
    public $reportDebitSum;
    public $reportCreditSum;
    public $fromDate;
    public $toDate;

    public function mount()
    {
        // dd($_GET);
        $this->query = $_GET['datax'];
        $this->fromDate = $_GET['from'];
        $this->toDate = $_GET['to'];

        $this->cleanQuery = explode(',', $this->query);
        // dd($this->cleanQuery);

        //
        $this->reportList = Account::whereHas(
            'transactions',
            fn($query) => $query->whereBetween(DB::raw('DATE(created_at)'), [$this->fromDate, $this->toDate]),
        )
            ->withSum(
                [
                    'transactions as db_sum' => fn($query) => $query
                        ->whereBetween(DB::raw('DATE(created_at)'), [$this->fromDate, $this->toDate])
                        ->where('type', 'debit'),
                ],
                'amount',
            )
            ->withSum(
                [
                    'transactions as crd_sum' => fn($query) => $query
                        ->whereBetween(DB::raw('DATE(created_at)'), [$this->fromDate, $this->toDate])
                        ->where('type', 'credit'),
                ],
                'amount',
            )
            ->get();

        // Report List Here
        // $this->reportList = Account::orderBy('created_at', 'DESC')->find($this->cleanQuery);
        $this->reportDebitSum = number_format($this->reportList->pluck('db_sum')->sum(), 2);
        $this->reportCreditSum = number_format($this->reportList->pluck('crd_sum')->sum(), 2);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('do_print')
                ->label(__('backend.print'))
                ->size('sm')
                ->color('warning')
                ->icon('heroicon-o-printer')
                ->action(function () {
                    $this->js('window.print()');
                }),
        ];
    }
}

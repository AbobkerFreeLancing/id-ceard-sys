<?php

namespace App\Filament\Pages;

use Filament\Tables\Contracts\HasTable;
use Filament\Schemas\Components\Grid;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component as Livewire;
use Packages\Accounting\Models\Account;
use Filament\Tables\Table;
use Livewire\Attributes\Url;

class AccountTrialBalancePage extends Page implements HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-scale';
    protected string $view = 'filament.pages.account-trial-balance-page';
    protected static ?int $navigationSort = 8;
    protected static ?string $slug = 'trial-balance';

    #[Url]
    public ?array $tableFilters = null;

    #[Url]
    public $tableSearch = '';

    // public function mount() {
    //     $this->tableSearch = 'd';
    // }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [30, 50, 80];
    }

    public static function shouldRegisterNavigation(): bool
    {
        // return auth()->user()->can('accounts_list') && config('bedaya.accounting_enabled');
        return false;
    }

    public static function getNavigationGroup(): ?string
    {
        return __('backend.financial_accounts');
    }

    public function getHeading(): string
    {
        return __('backend.trial_balance');
    }

    public function getTitle(): string|Htmlable
    {
        return __('backend.trial_balance');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.trial_balance');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('backend.account')),
                TextColumn::make('db_sum')
                    ->label(__('backend.debit'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('crd_sum')
                    ->label(__('backend.credit'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('balance')
                    ->label(__('backend.balance'))
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
            ])
            ->query(
                Account::query()
                    ->whereHas('transactions')
                    ->withSum(['transactions as db_sum' => fn($query) => $query->where('type', 'debit')], 'amount')
                    ->withSum(['transactions as crd_sum' => fn($query) => $query->where('type', 'credit')], 'amount')
                    ->orderBy('created_at', 'DESC'),
            )
            ->filtersFormColumns(2)
            ->filters(
                [
                    Filter::make('created_at')
                        ->schema([
                            Grid::make()->schema([
                                DatePicker::make('from')
                                    ->native(false)
                                    ->label(__('backend.from_date'))
                                    ->inlineLabel()
                                    ->default(now()->subMonth()),
                                DatePicker::make('to')
                                    ->native(false)
                                    ->label(__('backend.to_date'))
                                    ->inlineLabel()
                                    ->default(now()->addMonth()),
                            ]),
                        ])
                        ->indicateUsing(function (array $data): array {
                            $indicators = [];

                            if ($data['from'] ?? null) {
                                $indicators['from'] = __('backend.from') . ' : ' . $data['from'];
                            }

                            if ($data['to'] ?? null) {
                                $indicators['to'] = __('backend.to') . ' : ' . $data['to'];
                            }

                            return $indicators;
                        })
                        ->baseQuery(function (Builder $query, array $data): Builder {
                            return $query->when(
                                $data['from'] && $data['to'],
                                fn($query) => $query
                                    ->whereHas(
                                        'transactions',
                                        fn($query) => $query->whereBetween('created_at', [$data['from'], $data['to']]),
                                    )
                                    ->withSum(
                                        [
                                            'transactions as db_sum' => fn($query) => $query
                                                ->whereBetween('created_at', [$data['from'], $data['to']])
                                                ->where('type', 'debit'),
                                        ],
                                        'amount',
                                    )
                                    ->withSum(
                                        [
                                            'transactions as crd_sum' => fn($query) => $query
                                                ->whereBetween('created_at', [$data['from'], $data['to']])
                                                ->where('type', 'credit'),
                                        ],
                                        'amount',
                                    ),
                            );
                        }),
                ],
                layout: FiltersLayout::AboveContent,
            )
            ->recordActions([])
            ->headerActions([
                Action::make('reports_page')
                    ->label(__('backend.reports'))
                    ->size('sm')
                    ->color('success')
                    ->url(function (Livewire $livewire) {
                        return AccountTrialBalanceReportsPage::getUrl([
                            'from' => isset($_GET['tableFilters']['created_at']['from'])
                                ? $_GET['tableFilters']['created_at']['from']
                                : '2023-01-01',
                            'to' => isset($_GET['tableFilters']['created_at']['from'])
                                ? $_GET['tableFilters']['created_at']['to']
                                : '2025-12-31',
                            'datax' => collect($livewire->getTableRecords()->items())
                                ->map(function ($item) {
                                    return $item->id;
                                })
                                ->join(','),
                        ]);
                    }),
            ])
            ->toolbarActions([])
            ->striped();
    }
}

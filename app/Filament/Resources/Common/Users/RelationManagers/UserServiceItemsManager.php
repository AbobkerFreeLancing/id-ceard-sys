<?php

namespace App\Filament\Resources\Common\Users\RelationManagers;

use Packages\Accounting\Models\Account;
use Packages\Helpers\BedayaHelper;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserServiceItemsManager extends RelationManager
{
    protected static string $relationship = 'serviceItems';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('backend.services');
    }

    public static function modelLabel(): ?string
    {
        return __('backend.sale_invoice');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('backend.services');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([TextInput::make('name')->required()->maxLength(255)]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.name')->label(__('backend.service')),
                TextColumn::make('price')
                    ->label(__('backend.price'))
                    ->formatStateUsing(fn($state) => number_format($state, 0)),
                TextColumn::make('qty')->label(__('backend.count')),
                TextColumn::make('extra_fees')
                    ->label(__('backend.extra_fees'))
                    ->formatStateUsing(fn($state) => number_format($state, 0)),
                TextColumn::make('sub_total')
                    ->label(__('backend.total'))
                    ->formatStateUsing(fn($state) => number_format($state, 0))
                    ->extraAttributes(['lang' => 'en', 'xdx' => 'ooo'])
                    ->summarize(Sum::make()->formatStateUsing(fn($state) => setMoney($state))),
                TextColumn::make('created_at')->label(__('backend.created_at')),
            ])
            ->filters(
                [
                    Filter::make('created_at')
                        ->schema([
                            Radio::make('date_range')
                                ->label(__('backend.date'))
                                ->columnSpanFull()
                                ->inline()
                                ->options([
                                    'today' => __('backend.today'),
                                    'yesterday' => __('backend.yesterday'),
                                    'last_week' => __('backend.last_week'),
                                    'last_month' => __('backend.last_month_30'),
                                    'all' => __('backend.all'),
                                ])
                                ->default('today'),
                        ])
                        ->indicateUsing(function (array $data): ?string {
                            return match ($data['date_range'] ?? 'today') {
                                'today' => __('backend.today'),
                                'yesterday' => __('backend.yesterday'),
                                'last_week' => __('backend.last_week'),
                                'last_month' => __('backend.last_month_30'),
                                'all' => __('backend.all'),
                                default => null,
                            };
                        })

                        ->query(function (Builder $query, array $data): Builder {
                            $range = $data['date_range'] ?? 'today';
                            return match ($range) {
                                'today' => $query->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()]),
                                'yesterday' => $query->whereBetween('created_at', [
                                    now()->subDay()->startOfDay(),
                                    now()->subDay()->endOfDay(),
                                ]),
                                'last_week' => $query->whereBetween('created_at', [
                                    now()->subWeek()->startOfDay(),
                                    now()->endOfDay(),
                                ]),
                                'last_month' => $query->whereBetween('created_at', [
                                    now()->subMonth()->startOfDay(),
                                    now()->endOfDay(),
                                ]),
                                'all' => $query,
                                default => $query,
                            };
                        }),
                ],
                layout: FiltersLayout::AboveContent,
            )
            ->filtersFormColumns(1)
            ->headerActions([
                Action::make('pay_employee')
                    ->label(__('backend.pay_employee'))
                    ->icon('heroicon-o-credit-card')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalWidth('lg')
                    ->modalHeading(__('backend.invoice_create'))
                    ->modalSubmitActionLabel(__('backend.invoice_create'))
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('employee')
                                ->label(__('backend.employee'))
                                ->size(TextSize::Large)
                                ->state(fn(RelationManager $livewire) => $livewire->ownerRecord->name),
                            TextEntry::make('amount')
                                ->label(__('backend.amount'))
                                ->state(
                                    fn($livewire) => number_format(
                                        $livewire->getFilteredTableQuery()->sum('sub_total'),
                                        0,
                                    ),
                                )
                                ->size(TextSize::Large)
                                ->badge()
                                ->color('gray'),
                            TextEntry::make('amount_due')
                                ->label(__('backend.amount_due'))
                                ->size(TextSize::Large)
                                ->state(
                                    fn($livewire) => number_format(
                                        $livewire->getFilteredTableQuery()->sum('sub_total') *
                                            ($livewire->ownerRecord->service_percentage / 100),

                                        0,
                                    ),
                                )
                                ->badge(),
                            Select::make('account_from_id')
                                ->live(debounce: 1000)
                                ->label(fn() => __('backend.safe_and_bank_account'))
                                ->options(function ($get, RelationManager $livewire) {
                                    if ($get('is_cheque_payment')) {
                                        return Account::where('parent_id', $this->payable_papers_id)
                                            ->get()
                                            ->pluck('name_balance_currency', 'id');
                                    }
                                    return Account::whereIn('slug', ['bank_account', 'safe_account'])
                                        ->get()
                                        ->pluck('name_balance_currency', 'id');
                                })
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    ])
                    ->action(function (RelationManager $livewire, $data) {
                        $employee = $livewire->getOwnerRecord();
                        $servicesTotal = $livewire->getFilteredTableQuery()->sum('sub_total');

                        $totalAmount = $servicesTotal * ($employee->service_percentage / 100);

                        if ($totalAmount <= 0) {
                            Notification::make()
                                ->title('No pending earnings found for this selection.')
                                ->warning()
                                ->send();
                            return;
                        }

                        $employee->payments()->create([
                            'amount' => $totalAmount,
                            'account_from_id' => Account::find($data['account_from_id'])->id,
                            'account_to_id' => $employee->account->id,
                        ]);

                        Notification::make()->title(__('backend.invoice_created'))->success()->send();
                    }),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

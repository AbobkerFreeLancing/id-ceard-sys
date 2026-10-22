<?php

namespace App\Filament\Resources\Accounting;

use App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages\CreateAccountBalanceTransfer;
use App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages\EditAccountBalanceTransfer;
use App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages\ListAccountBalanceTransfers;
use App\Filament\Resources\Accounting\AccountBalanceTransferResource\Pages\ViewAccountBalanceTransfer;
use App\Models\Setting;
use Packages\Accounting\Models\Account;
use Packages\Accounting\Models\AccountBalanceTransfer;
use Packages\Helpers\BedayaHelper;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AccountBalanceTransferResource extends Resource
{
    protected static ?string $model = AccountBalanceTransfer::class;

    protected static bool $isScopedToTenant = false;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('account_balance_transfer') && config('bedaya.accounting_enabled');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
        // return auth()->user()->can('account_balance_transfer') && config('bedaya.accounting_enabled');
    }

    public static function getLabel(): ?string
    {
        return __('backend.balance_transfer');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.balance_transfers');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.balance_transfers'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('account_balance_transfer');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('account_balance_transfer') && $record->is_approved == false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('account_balance_transfer') && $record->is_approved == false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make([
                            Select::make('account_from_id')
                                ->label(__('backend.transfer_from'))
                                ->options(
                                    Account::whereIn('slug', ['bank_account', 'safe_account'])
                                        ->get()
                                        ->pluck('name_balance_currency', 'id'),
                                )
                                ->live(debounce: 1000)
                                ->required()
                                ->disabledOn('edit'),
                            Select::make('account_to_id')
                                ->label(__('backend.transfer_to'))
                                ->live(debounce: 1000)
                                ->required()
                                ->options(function (Get $get) {
                                    return Account::whereIn('slug', ['bank_account', 'safe_account'])
                                        ->where('id', '!=', $get('account_from_id'))
                                        ->get()
                                        ->pluck('name_balance_currency', 'id');
                                })
                                ->disabledOn('edit'),
                            TextInput::make('amount')
                                ->label(__('backend.amount'))
                                ->prefixIcon(Heroicon::OutlinedCreditCard)
                                ->numeric()
                                ->required()
                                ->minValue(1)
                                ->maxValue(function ($get) {
                                    if ($get('account_from_id') != null) {
                                        return Account::find($get('account_from_id'))->balance;
                                    }
                                }),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextInput::make('description')->label(__('backend.statement'))->maxLength(100),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->state(
                                    fn(
                                        AccountBalanceTransfer $record,
                                    ): ?string => $record->created_at?->diffForHumans(),
                                )
                                ->hidden(fn(?AccountBalanceTransfer $record) => $record === null),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->state(
                                    fn(
                                        AccountBalanceTransfer $record,
                                    ): ?string => $record->updated_at?->diffForHumans(),
                                )
                                ->hidden(fn(?AccountBalanceTransfer $record) => $record === null),
                        ]),
                ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('from.name_currency')->label(__('backend.transfer_from')),
                TextColumn::make('to.name_currency')->label(__('backend.transfer_to')),
                TextColumn::make('amount')
                    ->label(__('backend.amount'))
                    ->formatStateUsing(
                        fn($state, $record) => number_format($state, 2) .
                            ' ' .
                            Account::find($record->from->id)->currency->symbol,
                    ),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
                TextColumn::make('created_at')->label(__('backend.created_at')),
                TextColumn::make('creator.name')->label(__('backend.created_by')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->label(__('backend.approve'))
                    ->hidden(fn($record) => $record->is_approved)
                    ->icon('heroicon-o-banknotes')
                    ->requiresConfirmation()
                    ->schema([
                        Group::make([
                            TextEntry::make('amount')
                                ->label(__('backend.amount'))
                                ->formatStateUsing(
                                    fn($state, $record) => number_format($state, 2) .
                                        ' ' .
                                        Account::find($record->from->id)->currency->symbol,
                                ),
                            TextEntry::make('transfer_from')
                                ->label(__('backend.transfer_from'))
                                ->getStateUsing(fn($record) => $record->from->name_currency),
                            TextEntry::make('transfer_to')
                                ->label(__('backend.transfer_to'))
                                ->getStateUsing(fn($record) => $record->to->name_currency),
                        ])->columns(2),
                    ])
                    ->action(function ($record, $data) {
                        // From
                        $from = $record->from;
                        // To
                        $to = $record->to;

                        $from->balance -= (float) $record->amount;
                        $to->balance +=
                            (float) $record->amount * ($from->currency->exchange_rate / $to->currency->exchange_rate);

                        $from->save();
                        $to->save();

                        // Approve record
                        $record->is_approved = true;
                        $record->acc_from_exchange_rate = $from->currency->exchange_rate / $to->currency->exchange_rate;
                        $record->acc_to_exchange_rate = $to->currency->exchange_rate / $from->currency->exchange_rate;
                        $record->save();

                        // Transaction Log
                        $ref = BedayaHelper::transactionReference();

                        $from->transactions()->create([
                            'amount' => $record->amount,
                            'credit' => $record->amount,
                            'balance' => $from?->balance,
                            'ref_number' => $ref,
                            // 'invoice_number' => $record->ref_number,
                            'statement' => __('backend.withdraw') . ' - ' . __('backend.balance_transfer'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'credit',
                        ]);

                        $to->transactions()->create([
                            'amount' => $record->amount,
                            'debit' => $record->amount,
                            'balance' => $to?->balance,
                            'ref_number' => $ref,
                            // 'invoice_number' => $record->ref_number,
                            'statement' => __('backend.deposit') . ' - ' . __('backend.balance_transfer'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'debit',
                        ]);
                    }),
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton()->visible(fn($record) => $record->is_approved == false),
                ActionGroup::make([DeleteAction::make()->hidden(fn($record) => $record->is_approved == true)]),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccountBalanceTransfers::route('/'),
            'create' => CreateAccountBalanceTransfer::route('/create'),
            'edit' => EditAccountBalanceTransfer::route('/{record}/edit'),
            'view' => ViewAccountBalanceTransfer::route('/{record}'),
        ];
    }
}

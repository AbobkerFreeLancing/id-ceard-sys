<?php

namespace App\Filament\Resources\Accounting\Safes\Tables;

use App\Models\Setting;
use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Packages\Enum\Accounting\SafeBankTypeEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SafesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label(__('backend.code')),
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                TextColumn::make('balance')
                    ->label(__('backend.balance'))
                    ->badge()
                    ->color('gray')
                    ->size(TextSize::Large)
                    ->visible(fn() => auth()->user()->can('safe_balance_view'))
                    ->formatStateUsing(fn($state, $record) => setMoney($state) . ' ' . $record?->currency?->symbol)
                    ->summarize(Sum::make()->formatStateUsing(fn($state, $record) => setMoney($state))),
                TextColumn::make('account_type')
                    ->label(__('backend.account_type'))
                    ->formatStateUsing(fn($state) => SafeBankTypeEnum::tryFrom($state)->getLabel()),
                ToggleColumn::make('is_enabled')->label(__('backend.is_enabled')),
            ])
            ->filters([
                SelectFilter::make('account_type')
                    ->options(SafeBankTypeEnum::getOptions())
                    ->label(__('backend.account_type')),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                Action::make('account_movement')
                    ->icon('heroicon-o-document-text')
                    ->slideOver()
                    ->color(Color::Gray)
                    ->modalContent(
                        fn(Account $record) => view('bedaya:accounting::view-safe-movements', ['record' => $record]),
                    )
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->label(__('backend.account_movementx')),

                Action::make('account_recharge')
                    ->label(__('backend.account_rechargex'))
                    ->color(Color::Orange)
                    ->icon('heroicon-o-banknotes')
                    ->requiresConfirmation()
                    ->schema([
                        Section::make()
                            ->schema([TextEntry::make('name')->label(__('backend.account'))->inlineLabel()])
                            ->compact(),
                        TextInput::make('amount')->label(__('backend.amount'))->minValue(1)->numeric()->required(),
                        Select::make('credit_account_id')
                            ->label(__('backend.credit_account'))
                            ->options(
                                Account::where('type', 'credit')
                                    ->where('level_type', AccountLevelTypeEnum::Sub->value)
                                    ->get()
                                    ->pluck('name_balance_currency', 'id'),
                            )
                            ->searchable()
                            ->required(),
                        TextInput::make('notes')->label(__('backend.statement'))->required()->maxLength(100),
                    ])
                    ->action(function ($record, $data) {
                        $credit_acc = Account::whereId($data['credit_account_id'])->first();

                        $record->increment('balance', $data['amount']);
                        $credit_acc->increment('balance', $data['amount']);

                        // Create transactions
                        $ref = time() . random_int(1111, 9999);
                        $ref2 = time() . random_int(10000, 19999);

                        $record->transactions()->create([
                            'amount' => $data['amount'],
                            'debit' => $data['amount'],
                            'balance' => $record->balance,
                            'ref_number' => $ref,
                            'statement' => __('backend.deposit'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'notes' => $data['notes'],
                        ]);

                        $credit_acc->transactions()->create([
                            'amount' => $data['amount'],
                            'credit' => $data['amount'],
                            'balance' => $credit_acc->balance,
                            'ref_number' => $ref2,
                            'statement' => __('backend.deposit'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'notes' => $data['notes'],
                        ]);
                    }),
                ActionGroup::make([DeleteAction::make()->disabled(fn($record) => $record->balance > 0)]),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}

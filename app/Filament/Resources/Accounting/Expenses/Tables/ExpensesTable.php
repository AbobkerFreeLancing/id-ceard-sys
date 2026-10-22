<?php

namespace App\Filament\Resources\Accounting\Expenses\Tables;

use App\Models\Setting;
use Packages\Accounting\Models\Account;
use Packages\Helpers\BedayaHelper;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number'))->searchable(),
                TextColumn::make('account.name')->label(__('backend.expense_type')),
                TextColumn::make('amount')
                    ->searchable()
                    ->label(__('backend.amount'))
                    ->numeric(decimalPlaces: 2, decimalSeparator: '.', thousandsSeparator: ',')
                    ->suffix(fn($record) => ' ' . $record->payment_account->currency?->symbol)
                    ->summarize(Sum::make()->formatStateUsing(fn($state) => setMoney($state))),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
                TextColumn::make('payment_account.name')->label(__('backend.safe_and_bank_account'))->searchable(),
                TextColumn::make('expense_date')->label(__('backend.date')),
                TextColumn::make('created_at')->label(__('backend.created_at')),
                TextColumn::make('creator.full_name')
                    ->label(__('backend.created_by'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')->label(__('backend.from_date'))->native(false),
                        DatePicker::make('created_until')->label(__('backend.to_date'))->native(false)->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                TernaryFilter::make('is_approved')->label(__('backend.approved')),
                Filter::make('account')
                    ->schema([
                        Select::make('account')
                            ->label(__('backend.account'))
                            ->options(Account::where('slug', 'expenses')->first()->children->pluck('name', 'id')),
                    ])
                    ->indicateUsing(function (array $data): ?string {
                        if (!$data['account']) {
                            return null;
                        }
                        return __('backend.account') . ': ' . Account::find($data['account'])->name;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['account'],
                            fn(Builder $query, $account): Builder => $query->where('account_id', '=', $account),
                        );
                    }),
            ])
            ->recordActions([
                Action::make('approved')
                    ->label(__('backend.approve'))
                    ->modalHeading(__('backend.approve_payment'))
                    ->modalIcon(Heroicon::CurrencyDollar)
                    ->hidden(fn($record) => $record->is_approved)
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        // Todo: add DB::Transaction, to avoid failing..
                        $record->account->balance += (float) $record->amount;
                        $record->account->save();

                        $record->payment_account->balance -= (float) $record->amount;
                        $record->payment_account->save();

                        $record->is_approved = true;
                        $record->save();

                        // Add transactions log
                        $ref = BedayaHelper::transactionReference();

                        $record->account->transactions()->create([
                            'amount' => $record->amount,
                            'debit' => $record->amount,
                            'balance' =>
                                $record->account?->transactions()?->latest()?->first()?->balance + $record->amount,
                            // 'invoice_number' => $record->ref_number,
                            'ref_number' => $ref,
                            'statement' => __('backend.payment_voucher'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'debit',
                        ]);

                        // Safe Account
                        $record->payment_account->transactions()->create([
                            'amount' => $record->amount,
                            'credit' => $record->amount,
                            'balance' =>
                                $record->payment_account?->transactions()?->latest()?->first()?->balance -
                                $record->amount,
                            // 'invoice_number' => $record->ref_number,
                            'ref_number' => $ref,
                            'statement' => __('backend.payment_voucher'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'credit',
                        ]);
                    }),
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton()->hidden(fn($record) => $record->is_approved),
                ActionGroup::make([DeleteAction::make()->hidden(fn($record) => $record->is_approved)]),
            ])
            ->toolbarActions([]);
    }
}

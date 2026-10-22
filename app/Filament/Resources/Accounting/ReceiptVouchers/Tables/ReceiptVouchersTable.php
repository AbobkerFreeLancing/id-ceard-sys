<?php

namespace App\Filament\Resources\Accounting\ReceiptVouchers\Tables;

use App\Models\Setting;
use Packages\Accounting\Models\Account;
use Packages\Helpers\BedayaHelper;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReceiptVouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number'))->searchable(),
                TextColumn::make('receiver_account.name')->label(__('backend.receiver_account')),
                TextColumn::make('giver_account.name')->label(__('backend.revenue_account')),
                TextColumn::make('amount')
                    ->label(__('backend.amount'))
                    ->summarize(Sum::make()->formatStateUsing(fn($state) => setMoney($state)))
                    ->formatStateUsing(fn($state) => setMoney($state)),
                TextColumn::make('receipt_date')->label(__('backend.date')),
                IconColumn::make('is_approved')->label(__('backend.approved'))->boolean(),
                TextColumn::make('created_at')->label(__('backend.created_at'))->date(),
                TextColumn::make('creator.name')
                    ->label(__('backend.created_by'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')->label(__('backend.from_date'))->native(false),
                        DatePicker::make('created_until')->label(__('backend.to_date'))->default(now())->native(false),
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
                    })
                    ->columns(2),
                TernaryFilter::make('is_approved')->label(__('backend.approved')),
                SelectFilter::make('giver_account_id')
                    ->options(Account::where('slug', 'rev')->pluck('name', 'id'))
                    ->label(__('backend.account')),
                // SelectFilter::make('payment_method_id')->options(PaymentMethod::all()->pluck('name', 'id'))->label(__('backend.the_payment_method'))
            ])
            ->recordActions([
                Action::make('approved')
                    ->label(__('backend.approve'))
                    ->hidden(fn($record) => $record->is_approved)
                    ->icon('heroicon-o-rectangle-stack')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->receiver_account->balance += $record->amount;
                        $record->receiver_account->save();

                        $record->giver_account->balance += $record->amount;
                        $record->giver_account->save();

                        $record->is_approved = true;
                        $record->save();

                        // Add transactions log
                        $ref = BedayaHelper::transactionReference();

                        // Safe Account
                        $record->receiver_account->transactions()->create([
                            'amount' => $record->amount,
                            'debit' => $record->amount,
                            'balance' => $record->receiver_account?->balance,
                            'ref_number' => $ref,
                            'statement' => __('backend.receipt_voucher'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'debit',
                        ]);

                        // Erad Account
                        $record->giver_account->transactions()->create([
                            'amount' => $record->amount,
                            'credit' => $record->amount,
                            'balance' => $record->giver_account?->balance,
                            'ref_number' => $ref,
                            'statement' => __('backend.receipt_voucher'),
                            'financial_year_id' => Setting::find(1)->financial_year_id,
                            'type' => 'credit',
                        ]);
                    }),
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([DeleteAction::make()]),
            ])
            ->toolbarActions([]);
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Packages\Accounting\Models\Transaction;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Widgets\TableWidget as BaseWidget;

class TransactionsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return false;
        return auth()->user()->can('accounts_management') && config('bedaya.accounting_enabled');
    }

    protected function getTableHeading(): string|Htmlable|null
    {
        return __('backend.transactions_log') . ' - ' . __('backend.latest_entries');
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'default' => 12,
            'lg' => 12,
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaction::query()->latest()->limit(6))
            ->paginated(false)
            ->columns([
                TextColumn::make('account.name')->label(__('backend.account')),
                TextColumn::make('statement')->label(__('backend.statement')),
                TextColumn::make('amount')
                    ->label(__('backend.amount'))
                    ->formatStateUsing(fn($state) => number_format($state, 0)),
                TextColumn::make('created_at')->label(__('backend.date'))->date('d-m-Y H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([]);
    }
}

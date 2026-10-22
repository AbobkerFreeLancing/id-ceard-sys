<?php

namespace App\Filament\Widgets;

use Packages\Accounting\Models\Account;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Widgets\TableWidget as BaseWidget;

class BalanceSafeWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return false;
        // return auth()->user()->can('safes_management') && config('bedaya.accounting_enabled');
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableHeading(): string|Htmlable|null
    {
        return __('backend.safe_and_bank_accounts');
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'lg' => 6,
            'default' => 12,
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Account::query()->where('slug', 'safe_account')->enabled()->latest()->limit(4);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label(__('backend.name')),
            TextColumn::make('balance')
                ->label(__('backend.balance'))
                ->formatStateUsing(function ($state, $record) {
                    return number_format($state, 2) . ' ' . $record?->currency?->symbol;
                }),
        ];
    }
}

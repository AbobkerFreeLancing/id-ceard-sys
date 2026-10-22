<?php

namespace App\Filament\Resources\Accounting\Transactions;

use App\Filament\Resources\Accounting\Transactions\Pages\CreateTransaction;
use App\Filament\Resources\Accounting\Transactions\Pages\EditTransaction;
use App\Filament\Resources\Accounting\Transactions\Pages\ListTransactions;
use App\Filament\Resources\Accounting\Transactions\Pages\ViewTransaction;
use App\Filament\Resources\Accounting\Transactions\Schemas\TransactionForm;
use App\Filament\Resources\Accounting\Transactions\Schemas\TransactionInfolist;
use App\Filament\Resources\Accounting\Transactions\Tables\TransactionsTable;
use BackedEnum;
use Packages\Accounting\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?string $recordRouteKeyName = 'ref_number';

    public static function getNavigationGroup(): ?string
    {
        return __('backend.financial_accounts');
    }

    public static function getLabel(): ?string
    {
        return __('backend.transaction_details');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.transactions_log');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.transactions_log'));
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('accounts_management') && config('bedaya.accounting_enabled');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
        // return auth()->user()->can('accounts_management') && config('bedaya.accounting_enabled');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('accounts_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('accounts_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('accounts_management');
    }

    public static function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
            'view' => ViewTransaction::route('/{record:ref_number}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}

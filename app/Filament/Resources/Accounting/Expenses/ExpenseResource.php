<?php

namespace App\Filament\Resources\Accounting\Expenses;

use App\Filament\Resources\Accounting\Expenses\Pages\CreateExpense;
use App\Filament\Resources\Accounting\Expenses\Pages\EditExpense;
use App\Filament\Resources\Accounting\Expenses\Pages\ListExpenses;
use App\Filament\Resources\Accounting\Expenses\Pages\ViewExpense;
use App\Filament\Resources\Accounting\Expenses\Schemas\ExpenseForm;
use App\Filament\Resources\Accounting\Expenses\Schemas\ExpenseInfolist;
use App\Filament\Resources\Accounting\Expenses\Tables\ExpensesTable;
use Packages\Accounting\Models\Expense;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('expense_management') && config('bedaya.accounting_enabled');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('expense_management') && config('bedaya.accounting_enabled');
    }

    public static function getLabel(): ?string
    {
        return __('backend.expense');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.expenses');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.expenses'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('expense_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('expense_management') && !$record->is_approved;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('expense_management') && !$record->is_approved;
    }

    public static function form(Schema $schema): Schema
    {
        return ExpenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExpenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpensesTable::configure($table);
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
            'index' => ListExpenses::route('/'),
            'create' => CreateExpense::route('/create'),
            'view' => ViewExpense::route('/{record}'),
            'edit' => EditExpense::route('/{record}/edit'),
        ];
    }
}

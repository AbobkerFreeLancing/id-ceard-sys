<?php

namespace App\Filament\Resources\Accounting;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Packages\Accounting\Models\Account;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Packages\Accounting\Models\ExpenseType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Accounting\ExpenseTypeResource\Pages;
use App\Filament\Resources\Accounting\ExpenseTypeResource\RelationManagers;
use App\Filament\Resources\Accounting\ExpenseTypeResource\Pages\ListExpenseTypes;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\ToggleColumn;

class ExpenseTypeResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static bool $isScopedToTenant = false;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'expense-types';

    protected static ?int $navigationSort = 6;

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()
            ::query()
            ->whereHas('parent', function ($q) {
                return $q->where('slug', 'acc_administrative_expenses');
            });
    }

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getLabel(): ?string
    {
        return __('backend.expense_type');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.expense_types');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.expense_types'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('expense_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('expense_management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('backend.name'))
                    ->unique(ignoreRecord: true)
                    ->maxLength(75)
                    ->required()
                    ->columnSpan('full'),
                // Textarea::make('description')->label(__('backend.description'))->maxLength(200)->rows(2)->columnSpan('full')
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('name')->label(__('backend.name'))->searchable(),
                ToggleColumn::make('is_enabled')->label(__('backend.enabled')),
                TextColumn::make('balance')->label(__('backend.balance')),
                TextColumn::make('parent.name')->label(__('backend.parent_account')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconButton()->modalWidth(Width::Medium),
                ActionGroup::make([
                    DeleteAction::make()->disabled(fn($record) => auth()->user()->can('expense_management')),
                ]),
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
            'index' => ListExpenseTypes::route('/'),
            // 'create' => Pages\CreateExpenseType::route('/create'),
            // 'edit' => Pages\EditExpenseType::route('/{record}/edit'),
        ];
    }
}

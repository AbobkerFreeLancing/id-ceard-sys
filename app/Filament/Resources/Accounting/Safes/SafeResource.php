<?php

namespace App\Filament\Resources\Accounting\Safes;

use App\Filament\Resources\Accounting\Safes\Pages\CreateSafe;
use App\Filament\Resources\Accounting\Safes\Pages\EditSafe;
use App\Filament\Resources\Accounting\Safes\Pages\ListSafes;
use App\Filament\Resources\Accounting\Safes\Pages\ViewSafe;
use App\Filament\Resources\Accounting\Safes\Schemas\SafeForm;
use App\Filament\Resources\Accounting\Safes\Schemas\SafeInfolist;
use App\Filament\Resources\Accounting\Safes\Tables\SafesTable;
use BackedEnum;
use Packages\Accounting\Models\Account;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SafeResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCircleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('slug', 'safe_account');
    }

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('safes_management') && config('bedaya.accounting_enabled');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('safes_management') && config('bedaya.accounting_enabled');
    }

    public static function getLabel(): ?string
    {
        return __('backend.safe_and_bank_account');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.safe_and_bank_accounts');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.safe_and_bank_accounts'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('safes_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('safes_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('safes_management') &&
            $record->transactions()->count() == 0 &&
            $record->balance == 0;
    }

    public static function form(Schema $schema): Schema
    {
        return SafeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SafeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SafesTable::configure($table);
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
            'index' => ListSafes::route('/'),
            'create' => CreateSafe::route('/create'),
            'view' => ViewSafe::route('/{record}'),
            'edit' => EditSafe::route('/{record}/edit'),
        ];
    }
}

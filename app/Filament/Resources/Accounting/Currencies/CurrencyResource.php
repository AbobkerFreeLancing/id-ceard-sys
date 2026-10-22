<?php

namespace App\Filament\Resources\Accounting\Currencies;

use App\Filament\Resources\Accounting\Currencies\Pages\CreateCurrency;
use App\Filament\Resources\Accounting\Currencies\Pages\EditCurrency;
use App\Filament\Resources\Accounting\Currencies\Pages\ListCurrencies;
use App\Filament\Resources\Accounting\Currencies\Schemas\CurrencyForm;
use App\Filament\Resources\Accounting\Currencies\Tables\CurrenciesTable;
use BackedEnum;
use Packages\Accounting\Models\Currency;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.settings');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getLabel(): ?string
    {
        return __('backend.currency');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.currencies');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.currencies'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('currency_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('currency_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('currency_management') && $record->accounts()->count() == 0;
    }

    public static function form(Schema $schema): Schema
    {
        return CurrencyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CurrenciesTable::configure($table);
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
            'index' => ListCurrencies::route('/'),
            // 'create' => CreateCurrency::route('/create'),
            // 'edit' => EditCurrency::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Accounting\Taxes;

use App\Filament\Resources\Accounting\Taxes\Pages\CreateTax;
use App\Filament\Resources\Accounting\Taxes\Pages\EditTax;
use App\Filament\Resources\Accounting\Taxes\Pages\ListTaxes;
use App\Filament\Resources\Accounting\Taxes\Schemas\TaxForm;
use App\Filament\Resources\Accounting\Taxes\Tables\TaxesTable;
use BackedEnum;
use Packages\Accounting\Models\Tax;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TaxResource extends Resource
{
    protected static ?string $model = Tax::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function getLabel(): ?string
    {
        return __('backend.tax');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.taxes');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.taxes'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.accounting_enabled') && config('bedaya.taxes_enabled');
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function canDelete(Model $record): bool
    {
        return $record->is_editable;
    }

    public static function form(Schema $schema): Schema
    {
        return TaxForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaxesTable::configure($table);
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
            'index' => ListTaxes::route('/'),
            'create' => CreateTax::route('/create'),
            'edit' => EditTax::route('/{record}/edit'),
        ];
    }
}

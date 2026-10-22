<?php

namespace App\Filament\Resources\Common\Countries;

use App\Filament\Resources\Common\Countries\Pages\CreateCountry;
use App\Filament\Resources\Common\Countries\Pages\EditCountry;
use App\Filament\Resources\Common\Countries\Pages\ListCountries;
use App\Filament\Resources\Common\Countries\Pages\ViewCountry;
use App\Filament\Resources\Common\Countries\RelationManagers\CityRelationManager;
use App\Filament\Resources\Common\Countries\Schemas\CountryForm;
use App\Filament\Resources\Common\Countries\Schemas\CountryInfolist;
use App\Filament\Resources\Common\Countries\Tables\CountriesTable;
use BackedEnum;
use Packages\Common\Models\Country;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static bool $isScopedToTenant = false;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getLabel(): ?string
    {
        return __('backend.country');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.countries');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.countries'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CountryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
            CityRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'view' => ViewCountry::route('/{record}'),
            'edit' => EditCountry::route('/{record}/edit'),
        ];
    }
}

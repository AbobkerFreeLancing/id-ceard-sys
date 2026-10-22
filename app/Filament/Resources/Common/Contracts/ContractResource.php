<?php

namespace App\Filament\Resources\Common\Contracts;

use App\Filament\Resources\Common\Contracts\Pages\CreateContract;
use App\Filament\Resources\Common\Contracts\Pages\EditContract;
use App\Filament\Resources\Common\Contracts\Pages\ListContracts;
use App\Filament\Resources\Common\Contracts\Pages\ViewContract;
use App\Filament\Resources\Common\Contracts\Schemas\ContractForm;
use App\Filament\Resources\Common\Contracts\Schemas\ContractInfolist;
use App\Filament\Resources\Common\Contracts\Tables\ContractsTable;
use BackedEnum;
use Packages\Common\Models\Contract;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.users_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.contract');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.contracts');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.contracts');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.contracts_enabled') && auth()->user()->can('contracts_management');
    }

    public static function canAccess(): bool
    {
        return config('bedaya.contracts_enabled') && auth()->user()->can('contracts_management');
    }

    public static function canCreate(): bool
    {
        return config('bedaya.contracts_enabled') && auth()->user()->can('contracts_management');
    }

    public static function canEdit(Model $record): bool
    {
        return config('bedaya.contracts_enabled') && auth()->user()->can('contracts_management');
    }

    public static function canDelete(Model $record): bool
    {
        return config('bedaya.contracts_enabled') && auth()->user()->can('contracts_management');
    }

    public static function form(Schema $schema): Schema
    {
        return ContractForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContractInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContractsTable::configure($table);
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
            'index' => ListContracts::route('/'),
            'create' => CreateContract::route('/create'),
            'view' => ViewContract::route('/{record}'),
            'edit' => EditContract::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}

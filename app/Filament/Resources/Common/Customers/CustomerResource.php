<?php

namespace App\Filament\Resources\Common\Customers;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Packages\Common\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Common\Customers\Pages\EditCustomer;
use App\Filament\Resources\Common\Customers\Pages\ViewCustomer;
use App\Filament\Resources\Common\Customers\Pages\ListCustomers;
use App\Filament\Resources\Common\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Common\Customers\Schemas\CustomerForm;
use App\Filament\Resources\Common\Customers\Tables\CustomersTable;
use App\Filament\Resources\Common\Customers\Schemas\CustomerInfolist;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $tenantOwnershipRelationshipName = 'branch';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string
    {
        // return __("backend.services_module");
        return __('backend.users_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.customer');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.customers');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.customers'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.system_customers_enabled') && auth()->user()->can('customer_management');
    }

    public static function canAccess(): bool
    {
        return config('bedaya.system_customers_enabled') && auth()->user()->can('customer_management');
    }

    public static function canCreate(): bool
    {
        return config('bedaya.system_customers_enabled');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('customer_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('customer_management') && $record->sales()->count() == 0;
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CustomerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
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
            'index' => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'view' => ViewCustomer::route('/{record}'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}

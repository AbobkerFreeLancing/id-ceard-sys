<?php

namespace App\Filament\Resources\Common\Users;

use BackedEnum;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Common\Users\Pages\EditUser;
use App\Filament\Resources\Common\Users\Pages\ViewUser;
use App\Filament\Resources\Common\Users\Pages\ListUsers;
use App\Filament\Resources\Common\Users\Pages\CreateUser;
use App\Filament\Resources\Common\Users\Pages\ViewUserServicePayment;
use App\Filament\Resources\Common\Users\Schemas\UserForm;
use App\Filament\Resources\Common\Users\Tables\UsersTable;
use App\Filament\Resources\Common\Users\Schemas\UserInfolist;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $tenantOwnershipRelationshipName = 'branches';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __("backend.users_module");
    }

    public static function getLabel(): ?string
    {
        return __("backend.employee");
    }

    public static function getPluralLabel(): ?string
    {
        return __("backend.employees");
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__("backend.employees"));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('user_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('user_management');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('user_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('user_management');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('user_management')
            && !in_array('admin', $record->roles()->pluck('name')->toArray());
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
            'user-payment' => ViewUserServicePayment::route('/{record}/user-payment/{payment}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

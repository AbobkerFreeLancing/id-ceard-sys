<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // المسمى المفرد (يستخدم في أزرار مثل: إضافة مستخدم)
    protected static ?string $modelLabel = 'مستخدم';

    // المسمى الجمع (يستخدم كعنوان للصفحة وفي الترويسة)
    protected static ?string $pluralModelLabel = 'المستخدمين';

    // الاسم الظاهر في القائمة الجانبية (Navigation)
    protected static ?string $navigationLabel = 'المستخدمين';

    // مجموعة القائمة الجانبية إن أردت تصنيفه
    // protected static ?string $navigationGroup = 'إدارة النظام';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}

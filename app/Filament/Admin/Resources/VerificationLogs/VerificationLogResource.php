<?php

namespace App\Filament\Admin\Resources\VerificationLogs;

use App\Filament\Admin\Resources\VerificationLogs\Pages\CreateVerificationLog;
use App\Filament\Admin\Resources\VerificationLogs\Pages\EditVerificationLog;
use App\Filament\Admin\Resources\VerificationLogs\Pages\ListVerificationLogs;
use App\Filament\Admin\Resources\VerificationLogs\Schemas\VerificationLogForm;
use App\Filament\Admin\Resources\VerificationLogs\Tables\VerificationLogsTable;
use App\Models\VerificationLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class VerificationLogResource extends Resource
{
    protected static ?string $model = VerificationLog::class;

    protected static ?string $modelLabel = 'سجل فحص وتدقيق';

    protected static ?string $pluralModelLabel = 'سجلات الفحص الأمني';

    protected static ?string $navigationLabel = 'سجلات الفحص والرقابة';

    protected static string|UnitEnum|null $navigationGroup = 'الرقابة والأمان الميداني';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    public static function form(Schema $schema): Schema
    {
        return VerificationLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VerificationLogsTable::configure($table);
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
            'index' => ListVerificationLogs::route('/'),
            'create' => CreateVerificationLog::route('/create'),
            'edit' => EditVerificationLog::route('/{record}/edit'),
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

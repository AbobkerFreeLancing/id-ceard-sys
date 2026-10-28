<?php

namespace App\Filament\Admin\Resources\Cardholders;

use App\Filament\Admin\Resources\Cardholders\Pages\CreateCardholder;
use App\Filament\Admin\Resources\Cardholders\Pages\EditCardholder;
use App\Filament\Admin\Resources\Cardholders\Pages\ListCardholders;
use App\Filament\Admin\Resources\Cardholders\Schemas\CardholderForm;
use App\Filament\Admin\Resources\Cardholders\Tables\CardholdersTable;
use App\Models\Cardholder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CardholderResource extends Resource
{
    protected static ?string $model = Cardholder::class;

    protected static ?string $modelLabel = 'حامل بطاقة';

    protected static ?string $pluralModelLabel = 'حاملو البطاقات';

    protected static ?string $navigationLabel = 'حاملو البطاقات والتدقيق';

    protected static string|UnitEnum|null $navigationGroup = 'إدارة الهويات والبيانات';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    public static function form(Schema $schema): Schema
    {
        return CardholderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CardholdersTable::configure($table);
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
            'index' => ListCardholders::route('/'),
            'create' => CreateCardholder::route('/create'),
            'edit' => EditCardholder::route('/{record}/edit'),
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

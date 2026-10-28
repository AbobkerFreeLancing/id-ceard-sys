<?php

namespace App\Filament\Admin\Resources\Cards;

use App\Filament\Admin\Resources\Cards\Pages\CreateCard;
use App\Filament\Admin\Resources\Cards\Pages\EditCard;
use App\Filament\Admin\Resources\Cards\Pages\ListCards;
use App\Filament\Admin\Resources\Cards\Schemas\CardForm;
use App\Filament\Admin\Resources\Cards\Tables\CardsTable;
use App\Models\Card;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $modelLabel = 'بطاقة ذكية';

    protected static ?string $pluralModelLabel = 'سجل البطاقات الصادرة';

    protected static ?string $navigationLabel = 'سجل البطاقات المطبوعة';

    protected static string|UnitEnum|null $navigationGroup = 'إصدار وطباعة البطاقات';

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    public static function form(Schema $schema): Schema
    {
        return CardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CardsTable::configure($table);
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
            'index' => ListCards::route('/'),
            'create' => CreateCard::route('/create'),
            'edit' => EditCard::route('/{record}/edit'),
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

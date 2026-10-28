<?php

namespace App\Filament\Admin\Resources\CardBatches;

use App\Filament\Admin\Resources\CardBatches\Pages\CreateCardBatch;
use App\Filament\Admin\Resources\CardBatches\Pages\EditCardBatch;
use App\Filament\Admin\Resources\CardBatches\Pages\ListCardBatches;
use App\Filament\Admin\Resources\CardBatches\Schemas\CardBatchForm;
use App\Filament\Admin\Resources\CardBatches\Tables\CardBatchesTable;
use App\Models\CardBatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CardBatchResource extends Resource
{
    protected static ?string $model = CardBatch::class;

    protected static ?string $modelLabel = 'دفعة طباعة';

    protected static ?string $pluralModelLabel = 'دفعات الطباعة المجمعة';

    protected static ?string $navigationLabel = 'دفعات الطباعة (A4/CR80)';

    protected static string|UnitEnum|null $navigationGroup = 'إصدار وطباعة البطاقات';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPrinter;

    public static function form(Schema $schema): Schema
    {
        return CardBatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CardBatchesTable::configure($table);
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
            'index' => ListCardBatches::route('/'),
            'create' => CreateCardBatch::route('/create'),
            'edit' => EditCardBatch::route('/{record}/edit'),
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

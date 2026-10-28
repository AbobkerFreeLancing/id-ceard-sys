<?php

namespace App\Filament\Admin\Resources\CardTemplates;

use App\Filament\Admin\Resources\CardTemplates\Pages\CreateCardTemplate;
use App\Filament\Admin\Resources\CardTemplates\Pages\EditCardTemplate;
use App\Filament\Admin\Resources\CardTemplates\Pages\ListCardTemplates;
use App\Filament\Admin\Resources\CardTemplates\Schemas\CardTemplateForm;
use App\Filament\Admin\Resources\CardTemplates\Tables\CardTemplatesTable;
use App\Models\CardTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CardTemplateResource extends Resource
{
    protected static ?string $model = CardTemplate::class;

    protected static ?string $modelLabel = 'قالب بطاقة';

    protected static ?string $pluralModelLabel = 'قوالب البطاقات (CR80)';

    protected static ?string $navigationLabel = 'قوالب التصميم (CR80)';

    protected static string|UnitEnum|null $navigationGroup = 'إصدار وطباعة البطاقات';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    public static function form(Schema $schema): Schema
    {
        return CardTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CardTemplatesTable::configure($table);
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
            'index' => ListCardTemplates::route('/'),
            'create' => CreateCardTemplate::route('/create'),
            'edit' => EditCardTemplate::route('/{record}/edit'),
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

<?php

namespace App\Filament\Resources\University\Levels;

use App\Filament\Resources\University\Levels\Pages\CreateLevel;
use App\Filament\Resources\University\Levels\Pages\EditLevel;
use App\Filament\Resources\University\Levels\Pages\ListLevels;
use App\Filament\Resources\University\Levels\Pages\ViewLevel;
use App\Filament\Resources\University\Levels\Schemas\LevelForm;
use App\Filament\Resources\University\Levels\Schemas\LevelInfolist;
use App\Filament\Resources\University\Levels\Tables\LevelsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Level;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string
    {
        return __('backend.academic_structure_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.level');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.levels');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.levels');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('level_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('level_management');
    }

    public static function form(Schema $schema): Schema
    {
        return LevelForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LevelInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LevelsTable::configure($table);
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
            'index' => ListLevels::route('/'),
            'create' => CreateLevel::route('/create'),
            'view' => ViewLevel::route('/{record}'),
            'edit' => EditLevel::route('/{record}/edit'),
        ];
    }
}

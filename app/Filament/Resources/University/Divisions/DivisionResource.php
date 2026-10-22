<?php

namespace App\Filament\Resources\University\Divisions;

use App\Filament\Resources\University\Divisions\Pages\CreateDivision;
use App\Filament\Resources\University\Divisions\Pages\EditDivision;
use App\Filament\Resources\University\Divisions\Pages\ListDivisions;
use App\Filament\Resources\University\Divisions\Pages\ViewDivision;
use App\Filament\Resources\University\Divisions\Schemas\DivisionForm;
use App\Filament\Resources\University\Divisions\Schemas\DivisionInfolist;
use App\Filament\Resources\University\Divisions\Tables\DivisionsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Division;

class DivisionResource extends Resource
{
    protected static ?string $model = Division::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('backend.academic_structure_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.division');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.divisions');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.divisions');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('division_management') && false;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('division_management');
    }

    public static function form(Schema $schema): Schema
    {
        return DivisionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DivisionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DivisionsTable::configure($table);
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
            'index' => ListDivisions::route('/'),
            'create' => CreateDivision::route('/create'),
            'view' => ViewDivision::route('/{record}'),
            'edit' => EditDivision::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\University\Colleges;

use App\Filament\Resources\University\Colleges\Pages\CreateCollege;
use App\Filament\Resources\University\Colleges\Pages\EditCollege;
use App\Filament\Resources\University\Colleges\Pages\ListColleges;
use App\Filament\Resources\University\Colleges\Pages\ViewCollege;
use App\Filament\Resources\University\Colleges\Schemas\CollegeForm;
use App\Filament\Resources\University\Colleges\Schemas\CollegeInfolist;
use App\Filament\Resources\University\Colleges\Tables\CollegesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\College;

class CollegeResource extends Resource
{
    protected static ?string $model = College::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('backend.academic_structure_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.college');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.colleges');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.colleges');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('college_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('college_management');
    }

    public static function form(Schema $schema): Schema
    {
        return CollegeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CollegeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollegesTable::configure($table);
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
            'index' => ListColleges::route('/'),
            'create' => CreateCollege::route('/create'),
            'view' => ViewCollege::route('/{record}'),
            'edit' => EditCollege::route('/{record}/edit'),
        ];
    }
}

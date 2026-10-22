<?php

namespace App\Filament\Resources\University\AcademicYears;

use App\Filament\Resources\University\AcademicYears\Pages\CreateAcademicYear;
use App\Filament\Resources\University\AcademicYears\Pages\EditAcademicYear;
use App\Filament\Resources\University\AcademicYears\Pages\ListAcademicYears;
use App\Filament\Resources\University\AcademicYears\Pages\ViewAcademicYear;
use App\Filament\Resources\University\AcademicYears\Schemas\AcademicYearForm;
use App\Filament\Resources\University\AcademicYears\Schemas\AcademicYearInfolist;
use App\Filament\Resources\University\AcademicYears\Tables\AcademicYearsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\AcademicYear;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'year';

    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): string
    {
        return __('backend.academic_structure_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.academic_year');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.study_years');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.study_years');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('study_year_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('study_year_management');
    }

    public static function form(Schema $schema): Schema
    {
        return AcademicYearForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AcademicYearInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AcademicYearsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
                //
                // SemestersRelationManager::class,
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAcademicYears::route('/'),
            'create' => CreateAcademicYear::route('/create'),
            'view' => ViewAcademicYear::route('/{record}'),
            'edit' => EditAcademicYear::route('/{record}/edit'),
        ];
    }
}

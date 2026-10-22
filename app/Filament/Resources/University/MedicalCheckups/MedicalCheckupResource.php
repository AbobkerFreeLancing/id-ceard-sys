<?php

namespace App\Filament\Resources\University\MedicalCheckups;

use App\Filament\Resources\University\MedicalCheckups\Pages\CreateMedicalCheckup;
use App\Filament\Resources\University\MedicalCheckups\Pages\EditMedicalCheckup;
use App\Filament\Resources\University\MedicalCheckups\Pages\ListMedicalCheckups;
use App\Filament\Resources\University\MedicalCheckups\Pages\ViewMedicalCheckup;
use App\Filament\Resources\University\MedicalCheckups\Schemas\MedicalCheckupForm;
use App\Filament\Resources\University\MedicalCheckups\Schemas\MedicalCheckupInfolist;
use App\Filament\Resources\University\MedicalCheckups\Tables\MedicalCheckupsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\MedicalCheckup;

class MedicalCheckupResource extends Resource
{
    protected static ?string $model = MedicalCheckup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.medical_checkup_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.medical_checkup_record');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.medical_checkup_records');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.medical_checkup_records');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('medical_checkup_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('medical_checkup_management');
    }

    public static function form(Schema $schema): Schema
    {
        return MedicalCheckupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MedicalCheckupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicalCheckupsTable::configure($table);
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
            'index' => ListMedicalCheckups::route('/'),
            'create' => CreateMedicalCheckup::route('/create'),
            'view' => ViewMedicalCheckup::route('/{record}'),
            'edit' => EditMedicalCheckup::route('/{record}/edit'),
        ];
    }
}

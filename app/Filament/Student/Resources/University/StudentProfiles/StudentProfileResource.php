<?php

namespace App\Filament\Student\Resources\University\StudentProfiles;

use App\Filament\Student\Resources\University\StudentProfiles\Pages\CreateStudentProfile;
use App\Filament\Student\Resources\University\StudentProfiles\Pages\EditStudentProfile;
use App\Filament\Student\Resources\University\StudentProfiles\Pages\ListStudentProfiles;
use App\Filament\Student\Resources\University\StudentProfiles\Pages\ViewStudentProfile;
use App\Filament\Student\Resources\University\StudentProfiles\Schemas\StudentProfileForm;
use App\Filament\Student\Resources\University\StudentProfiles\Schemas\StudentProfileInfolist;
use App\Filament\Student\Resources\University\StudentProfiles\Tables\StudentProfilesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Student;

class StudentProfileResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_profile');
    }

    public static function getLabel(): ?string
    {
        return __('backend.basic_info_edit');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.basic_info_edit');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.basic_info_edit');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return StudentProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentProfileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentProfilesTable::configure($table);
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
            'index' => ListStudentProfiles::route('/'),
            'view' => ViewStudentProfile::route('/{record}'),
            'edit' => EditStudentProfile::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\University\Students;

use App\Filament\Resources\University\Students\Pages\CreateStudent;
use App\Filament\Resources\University\Students\Pages\EditStudent;
use App\Filament\Resources\University\Students\Pages\ListStudents;
use App\Filament\Resources\University\Students\Pages\ViewStudent;
use App\Filament\Resources\University\Students\RelationManagers\StudentChargesRelationManager;
use App\Filament\Resources\University\Students\RelationManagers\StudentIdentitiesRelationManager;
use App\Filament\Resources\University\Students\Schemas\StudentForm;
use App\Filament\Resources\University\Students\Schemas\StudentInfolist;
use App\Filament\Resources\University\Students\Tables\StudentsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Student;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.student');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.students');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.students');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('student_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('student_management');
    }

    public static function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
            StudentChargesRelationManager::class,
            StudentIdentitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'view' => ViewStudent::route('/{record}'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}

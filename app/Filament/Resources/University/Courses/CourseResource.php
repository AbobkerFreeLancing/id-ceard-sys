<?php

namespace App\Filament\Resources\University\Courses;

use App\Filament\Resources\University\Courses\Pages\CreateCourse;
use App\Filament\Resources\University\Courses\Pages\EditCourse;
use App\Filament\Resources\University\Courses\Pages\ListCourses;
use App\Filament\Resources\University\Courses\Pages\ViewCourse;
use App\Filament\Resources\University\Courses\Schemas\CourseForm;
use App\Filament\Resources\University\Courses\Schemas\CourseInfolist;
use App\Filament\Resources\University\Courses\Tables\CoursesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Course;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.course');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.courses');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.courses');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('course_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('course_management');
    }

    public static function form(Schema $schema): Schema
    {
        return CourseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CourseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoursesTable::configure($table);
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
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'view' => ViewCourse::route('/{record}'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}

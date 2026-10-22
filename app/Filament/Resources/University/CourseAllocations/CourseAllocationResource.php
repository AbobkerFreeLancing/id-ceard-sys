<?php

namespace App\Filament\Resources\University\CourseAllocations;

use App\Filament\Resources\University\CourseAllocations\Pages\CreateCourseAllocation;
use App\Filament\Resources\University\CourseAllocations\Pages\EditCourseAllocation;
use App\Filament\Resources\University\CourseAllocations\Pages\ListCourseAllocations;
use App\Filament\Resources\University\CourseAllocations\Pages\ViewCourseAllocation;
use App\Filament\Resources\University\CourseAllocations\Schemas\CourseAllocationForm;
use App\Filament\Resources\University\CourseAllocations\Schemas\CourseAllocationInfolist;
use App\Filament\Resources\University\CourseAllocations\Tables\CourseAllocationsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\CourseAllocation;

class CourseAllocationResource extends Resource
{
    protected static ?string $model = CourseAllocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.course_allocation');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.course_allocations');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.course_allocations');
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
        return CourseAllocationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CourseAllocationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseAllocationsTable::configure($table);
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
            'index' => ListCourseAllocations::route('/'),
            'create' => CreateCourseAllocation::route('/create'),
            'view' => ViewCourseAllocation::route('/{record}'),
            'edit' => EditCourseAllocation::route('/{record}/edit'),
        ];
    }
}

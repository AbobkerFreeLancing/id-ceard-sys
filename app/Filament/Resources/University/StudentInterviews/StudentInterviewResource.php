<?php

namespace App\Filament\Resources\University\StudentInterviews;

use App\Filament\Resources\University\StudentInterviews\Pages\CreateStudentInterview;
use App\Filament\Resources\University\StudentInterviews\Pages\EditStudentInterview;
use App\Filament\Resources\University\StudentInterviews\Pages\ListStudentInterviews;
use App\Filament\Resources\University\StudentInterviews\Pages\ViewStudentInterview;
use App\Filament\Resources\University\StudentInterviews\Schemas\StudentInterviewForm;
use App\Filament\Resources\University\StudentInterviews\Schemas\StudentInterviewInfolist;
use App\Filament\Resources\University\StudentInterviews\Tables\StudentInterviewsTable;
use App\Filament\Resources\University\StudentInterviews\Widgets\StudentInterviewStatsOverview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\StudentInterview;

class StudentInterviewResource extends Resource
{
    protected static ?string $model = StudentInterview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 11;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_interviews_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.student_interview');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.student_interviews');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.student_interviews');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('student_interviews_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('student_interviews_management');
    }

    public static function form(Schema $schema): Schema
    {
        return StudentInterviewForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentInterviewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentInterviewsTable::configure($table);
    }

    public static function getWidgets(): array
    {
        return [
            StudentInterviewStatsOverview::class,
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentInterviews::route('/'),
            'view' => ViewStudentInterview::route('/{record}'),
            'edit' => EditStudentInterview::route('/{record}/edit'),
        ];
    }
}

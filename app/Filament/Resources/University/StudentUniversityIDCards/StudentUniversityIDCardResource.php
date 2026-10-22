<?php

namespace App\Filament\Resources\University\StudentUniversityIDCards;

use App\Filament\Resources\University\StudentUniversityIDCards\Pages\CreateStudentUniversityIDCard;
use App\Filament\Resources\University\StudentUniversityIDCards\Pages\EditStudentUniversityIDCard;
use App\Filament\Resources\University\StudentUniversityIDCards\Pages\ListStudentUniversityIDCards;
use App\Filament\Resources\University\StudentUniversityIDCards\Pages\PrintStudentUniversityIDCard;
use App\Filament\Resources\University\StudentUniversityIDCards\Pages\ViewStudentUniversityIDCard;
use App\Filament\Resources\University\StudentUniversityIDCards\Schemas\StudentUniversityIDCardForm;
use App\Filament\Resources\University\StudentUniversityIDCards\Schemas\StudentUniversityIDCardInfolist;
use App\Filament\Resources\University\StudentUniversityIDCards\Tables\StudentUniversityIDCardsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\StudentUniversityIDCard;

class StudentUniversityIDCardResource extends Resource
{
    protected static ?string $model = StudentUniversityIDCard::class;

    protected static ?string $slug = 'student-university-cards';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs');
    }

    public static function getLabel(): ?string
    {
        return __('backend.university_id_card');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.university_id_cards');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.university_id_cards');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('university_id_cards_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('university_id_cards_management');
    }

    public static function form(Schema $schema): Schema
    {
        return StudentUniversityIDCardForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentUniversityIDCardInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentUniversityIDCardsTable::configure($table);
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
            'index' => ListStudentUniversityIDCards::route('/'),
            'create' => CreateStudentUniversityIDCard::route('/create'),
            'view' => ViewStudentUniversityIDCard::route('/{record}'),
            'print' => PrintStudentUniversityIDCard::route('/{record}/print'),
            'edit' => EditStudentUniversityIDCard::route('/{record}/edit'),
        ];
    }
}

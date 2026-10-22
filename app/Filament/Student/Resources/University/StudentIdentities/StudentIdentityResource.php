<?php

namespace App\Filament\Student\Resources\University\StudentIdentities;

use App\Filament\Student\Resources\University\StudentIdentities\Pages\CreateStudentIdentity;
use App\Filament\Student\Resources\University\StudentIdentities\Pages\EditStudentIdentity;
use App\Filament\Student\Resources\University\StudentIdentities\Pages\ListStudentIdentities;
use App\Filament\Student\Resources\University\StudentIdentities\Pages\ViewStudentIdentity;
use App\Filament\Student\Resources\University\StudentIdentities\Schemas\StudentIdentityForm;
use App\Filament\Student\Resources\University\StudentIdentities\Schemas\StudentIdentityInfolist;
use App\Filament\Student\Resources\University\StudentIdentities\Tables\StudentIdentitiesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\StudentIdentity;

class StudentIdentityResource extends Resource
{
    protected static ?string $model = StudentIdentity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_profile');
    }

    public static function getLabel(): ?string
    {
        return __('backend.identity');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.identities');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.identities');
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
        return StudentIdentityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentIdentityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentIdentitiesTable::configure($table);
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
            'index' => ListStudentIdentities::route('/'),
            'create' => CreateStudentIdentity::route('/create'),
            'view' => ViewStudentIdentity::route('/{record}'),
            'edit' => EditStudentIdentity::route('/{record}/edit'),
        ];
    }
}

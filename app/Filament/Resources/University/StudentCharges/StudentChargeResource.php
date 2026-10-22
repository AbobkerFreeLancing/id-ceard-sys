<?php

namespace App\Filament\Resources\University\StudentCharges;

use App\Filament\Resources\University\StudentCharges\Pages\CreateStudentCharge;
use App\Filament\Resources\University\StudentCharges\Pages\EditStudentCharge;
use App\Filament\Resources\University\StudentCharges\Pages\ListStudentCharges;
use App\Filament\Resources\University\StudentCharges\Pages\PrintSelectedStudentCharges;
use App\Filament\Resources\University\StudentCharges\Pages\PrintStudentChargeInvoice;
use App\Filament\Resources\University\StudentCharges\Pages\ViewStudentCharge;
use App\Filament\Resources\University\StudentCharges\RelationManagers\ChargesPaymentsRelationManager;
use App\Filament\Resources\University\StudentCharges\Schemas\StudentChargeForm;
use App\Filament\Resources\University\StudentCharges\Schemas\StudentChargeInfolist;
use App\Filament\Resources\University\StudentCharges\Tables\StudentChargesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\StudentCharge;

class StudentChargeResource extends Resource
{
    protected static ?string $model = StudentCharge::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return __('backend.fee_management_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.student_charge');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.students_charges');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.students_charges');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('student_charges_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('student_charges_management');
    }

    public static function form(Schema $schema): Schema
    {
        return StudentChargeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentChargeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentChargesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [ChargesPaymentsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentCharges::route('/'),
            'create' => CreateStudentCharge::route('/create'),
            'print-selected' => PrintSelectedStudentCharges::route('/print-selected'),
            'view' => ViewStudentCharge::route('/{record}'),
            'invoice' => PrintStudentChargeInvoice::route('/{record}/invoice'),
            'edit' => EditStudentCharge::route('/{record}/edit'),
        ];
    }
}

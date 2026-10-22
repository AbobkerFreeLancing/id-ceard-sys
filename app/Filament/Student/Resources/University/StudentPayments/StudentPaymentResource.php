<?php

namespace App\Filament\Student\Resources\University\StudentPayments;

use App\Filament\Student\Resources\University\StudentPayments\Pages\CreateStudentPayment;
use App\Filament\Student\Resources\University\StudentPayments\Pages\EditStudentPayment;
use App\Filament\Student\Resources\University\StudentPayments\Pages\ListStudentPayments;
use App\Filament\Student\Resources\University\StudentPayments\Pages\ViewStudentPayment;
use App\Filament\Student\Resources\University\StudentPayments\Schemas\StudentPaymentForm;
use App\Filament\Student\Resources\University\StudentPayments\Schemas\StudentPaymentInfolist;
use App\Filament\Student\Resources\University\StudentPayments\Tables\StudentPaymentsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Payment;

class StudentPaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function getLabel(): ?string
    {
        return __('backend.payment');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.payments');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.payments');
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
        return StudentPaymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentPaymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentPaymentsTable::configure($table);
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
            'index' => ListStudentPayments::route('/'),
            'create' => CreateStudentPayment::route('/create'),
            'view' => ViewStudentPayment::route('/{record}'),
            'edit' => EditStudentPayment::route('/{record}/edit'),
        ];
    }
}

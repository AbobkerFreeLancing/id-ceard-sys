<?php

namespace App\Filament\Resources\University\Payments;

use App\Filament\Resources\University\Payments\Pages\CreatePayment;
use App\Filament\Resources\University\Payments\Pages\EditPayment;
use App\Filament\Resources\University\Payments\Pages\ListPayments;
use App\Filament\Resources\University\Payments\Pages\PrintSelectedPayments;
use App\Filament\Resources\University\Payments\Pages\ViewPaymentInvoice;
use App\Filament\Resources\University\Payments\Pages\ViewPayment;
use App\Filament\Resources\University\Payments\Schemas\PaymentForm;
use App\Filament\Resources\University\Payments\Schemas\PaymentInfolist;
use App\Filament\Resources\University\Payments\Tables\PaymentsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Payment;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptRefund;

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
        return auth()->user()->can('student_payments_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('student_payments_management');
    }

    public static function form(Schema $schema): Schema
    {
        return PaymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PaymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
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
            'index' => ListPayments::route('/'),
            'create' => CreatePayment::route('/create'),
            'print-selected' => PrintSelectedPayments::route('/print-selected'),
            'view' => ViewPayment::route('/{record}'),
            'invoice' => ViewPaymentInvoice::route('/{record}/invoice'),
            'edit' => EditPayment::route('/{record}/edit'),
        ];
    }
}

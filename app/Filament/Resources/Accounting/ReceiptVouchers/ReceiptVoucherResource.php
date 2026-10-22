<?php

namespace App\Filament\Resources\Accounting\ReceiptVouchers;

use App\Filament\Resources\Accounting\ReceiptVouchers\Pages\CreateReceiptVoucher;
use App\Filament\Resources\Accounting\ReceiptVouchers\Pages\EditReceiptVoucher;
use App\Filament\Resources\Accounting\ReceiptVouchers\Pages\ListReceiptVouchers;
use App\Filament\Resources\Accounting\ReceiptVouchers\Pages\ViewReceiptVoucher;
use App\Filament\Resources\Accounting\ReceiptVouchers\Schemas\ReceiptVoucherForm;
use App\Filament\Resources\Accounting\ReceiptVouchers\Tables\ReceiptVouchersTable;
use Packages\Accounting\Models\ReceiptVoucher;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ReceiptVoucherResource extends Resource
{
    protected static ?string $model = ReceiptVoucher::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('receipt_vouchers_management') &&
            config('bedaya.accounting_enabled') &&
            config('bedaya.receipt_vouchers_enabled');
    }

    public static function getLabel(): ?string
    {
        return __('backend.receipt_voucher');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.receipt_vouchers');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.receipt_vouchers'));
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('receipt_vouchers_management');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('receipt_vouchers_management') && !$record->is_approved;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('receipt_vouchers_management') && !$record->is_approved;
    }

    public static function form(Schema $schema): Schema
    {
        return ReceiptVoucherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReceiptVouchersTable::configure($table);
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
            'index' => ListReceiptVouchers::route('/'),
            'create' => CreateReceiptVoucher::route('/create'),
            'edit' => EditReceiptVoucher::route('/{record}/edit'),
            'view' => ViewReceiptVoucher::route('/{record}'),
        ];
    }
}

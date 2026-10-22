<?php

namespace App\Filament\Resources\University\Invoices;

use App\Filament\Resources\University\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\University\Invoices\Pages\EditInvoice;
use App\Filament\Resources\University\Invoices\Pages\ListInvoices;
use App\Filament\Resources\University\Invoices\Pages\ViewInvoice;
use App\Filament\Resources\University\Invoices\Schemas\InvoiceForm;
use App\Filament\Resources\University\Invoices\Schemas\InvoiceInfolist;
use App\Filament\Resources\University\Invoices\Tables\InvoicesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\Invoice;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'ref_number';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('backend.financial_accounts');
    }

    public static function getLabel(): ?string
    {
        return __('backend.invoice');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.invoices');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.invoices');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false && auth()->user()->can('student_invoices_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('student_invoices_management');
    }

    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvoiceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
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
            'index' => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'view' => ViewInvoice::route('/{record}'),
            'edit' => EditInvoice::route('/{record}/edit'),
        ];
    }
}

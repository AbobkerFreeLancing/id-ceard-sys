<?php

namespace App\Filament\Resources\University\Invoices\Pages;

use App\Filament\Resources\University\Invoices\InvoiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Packages\University\Enums\InvoicePaymentStatusEnum;
use Packages\University\Models\Invoice;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('backend.all'))
                ->query(fn($query) => $query)
                ->badge(Invoice::count())
                ->badgeColor('gray'),

            __('backend.unpaid') => Tab::make()
                ->query(fn($query) => $query->where('payment_status', InvoicePaymentStatusEnum::Unpaid->value))
                ->badge(Invoice::where('payment_status', InvoicePaymentStatusEnum::Unpaid->value)->count())
                ->badgeColor('danger'),

            __('backend.partially_paid') => Tab::make()
                ->query(fn($query) => $query->where('payment_status', InvoicePaymentStatusEnum::PartiallyPaid->value))
                ->badge(Invoice::where('payment_status', InvoicePaymentStatusEnum::PartiallyPaid->value)->count())
                ->badgeColor('warning'),

            __('backend.paid') => Tab::make()
                ->query(fn($query) => $query->where('payment_status', InvoicePaymentStatusEnum::Paid->value))
                ->badge(Invoice::where('payment_status', InvoicePaymentStatusEnum::Paid->value)->count())
                ->badgeColor('success'),
        ];
    }
}

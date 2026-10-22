<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ServicesModule\ServiceInvoices\ServiceInvoiceResource;
use Packages\Services\Models\ServiceInvoice;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;

class ServiceInvoicesWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return config('bedaya.services_module_enabled') && auth()->user()->can('service_invoice_management');
    }

    protected function getTableHeading(): string | Htmlable | null
    {
        return __('backend.service_invoices');
    }

    public function getColumnSpan(): int | string | array
    {
        return [
            'default' => 12,
            'lg' => 12,
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ServiceInvoice::query()->latest()->limit(6))
            ->paginated(false)
            ->recordUrl(fn($record) => ServiceInvoiceResource::getUrl('view', [$record->id]))
            ->columns([
                TextColumn::make('ref_number')->label(__('backend.ref_number')),
                TextColumn::make('total')->label(__('backend.total'))
                    ->formatStateUsing(fn($state) => number_format($state, 2) . ' ' . getMainCurrency()->symbol),
                TextColumn::make('items_count')->counts('items')->label(__('backend.services')),
                TextColumn::make('created_at')->label(__('backend.added_at')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('view_invoice')
                ->label(__('backend.action_view'))
                ->icon(Heroicon::Eye)
                ->url(fn($record) => ServiceInvoiceResource::getUrl('view', [$record->id]))
            ])
            ->toolbarActions([]);
    }
}

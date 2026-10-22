<?php

namespace App\Filament\Resources\Support\Tickets\Pages;

use Filament\Actions\CreateAction;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\Support\Tickets\TicketResource;
use Packages\Support\Models\Ticket;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('backend.view_all')),
            __('backend.status_open') => Tab::make()->query(fn ($query) => $query->where('status', 'open'))
            ->badge(Ticket::where('status', 'open')->count())->badgeColor('success'),
            __('backend.in_progress') => Tab::make()->query(fn ($query) => $query->where('status', 'in_progress'))
            ->badge(Ticket::where('status', 'in_progress')->count())->badgeColor('warning'),
            __('backend.closed') => Tab::make()->query(fn ($query) => $query->where('status', 'closed'))
            ->badge(Ticket::where('status', 'closed')->count())->badgeColor('danger'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Support\Tickets\Pages;

use App\Filament\Resources\Support\Tickets\TicketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'إدارة تذكرة الدعم: ' . ($this->record->ticket_number ?? ('#' . $this->record->id));
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

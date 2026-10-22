<?php

namespace App\Filament\Resources\Support\Tickets\Pages;

use App\Filament\Resources\Support\Tickets\TicketResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;
}

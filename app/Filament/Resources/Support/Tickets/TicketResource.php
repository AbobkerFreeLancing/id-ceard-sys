<?php

namespace App\Filament\Resources\Support\Tickets;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Packages\Support\Models\Ticket;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Support\Tickets\Pages\EditTicket;
use App\Filament\Resources\Support\Tickets\Pages\ListTickets;
use App\Filament\Resources\Support\Tickets\Pages\CreateTicket;
use App\Filament\Resources\Support\Tickets\Schemas\TicketForm;
use App\Filament\Resources\Support\Tickets\Tables\TicketsTable;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLifebuoy;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getLabel(): ?string
    {
        return __('backend.ticket');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.tickets');
    }

    public static function getNavigationGroup(): string
    {
        return __('backend.support_module');
    }

    public static function getNavigationLabel(): string
    {
        return ucfirst(__('backend.tickets'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('bedaya.support_tickets_enabled') && auth()->user()->can('support_ticket_management');
    }

    public static function canAccess(): bool
    {
        return config('bedaya.support_tickets_enabled') && auth()->user()->can('support_ticket_management');
    }

    public static function form(Schema $schema): Schema
    {
        return TicketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Support\Tickets\RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'create' => CreateTicket::route('/create'),
            'edit' => EditTicket::route('/{record}/edit'),
        ];
    }
}

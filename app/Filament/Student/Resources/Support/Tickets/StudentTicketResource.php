<?php

namespace App\Filament\Student\Resources\Support\Tickets;

use App\Filament\Student\Resources\Support\Tickets\Pages\CreateStudentTicket;
use App\Filament\Student\Resources\Support\Tickets\Pages\ListStudentTickets;
use App\Filament\Student\Resources\Support\Tickets\Pages\ViewStudentTicket;
use App\Filament\Student\Resources\Support\Tickets\Schemas\StudentTicketForm;
use App\Filament\Student\Resources\Support\Tickets\Tables\StudentTicketsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\Support\Models\Ticket;
use Packages\University\Models\Student;

class StudentTicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLifebuoy;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $slug = 'tickets';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('backend.support_module');
    }

    public static function getLabel(): ?string
    {
        return 'تذكرة دعم فني';
    }

    public static function getPluralLabel(): ?string
    {
        return 'تذاكر الدعم الفني';
    }

    public static function getNavigationLabel(): string
    {
        return 'الدعم الفني والشكاوى';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('ticketable_type', Student::class)
            ->where('ticketable_id', student()?->id);
    }

    public static function form(Schema $schema): Schema
    {
        return StudentTicketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentTicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentTickets::route('/'),
            'create' => CreateStudentTicket::route('/create'),
            'view' => ViewStudentTicket::route('/{record}'),
        ];
    }
}

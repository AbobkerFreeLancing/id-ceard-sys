<?php

namespace App\Filament\Student\Resources\Support\Tickets\Pages;

use App\Filament\Student\Resources\Support\Tickets\StudentTicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Packages\Enum\TicketStatusEnum;

class ListStudentTickets extends ListRecords
{
    protected static string $resource = StudentTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('فتح تذكرة دعم فني جديدة')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->color('primary'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('جميع التذاكر'),
            'open' => Tab::make('المفتوحة')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', TicketStatusEnum::Open->value)),
            'in_progress' => Tab::make('قيد المعالجة')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', TicketStatusEnum::InProgress->value)),
            'closed' => Tab::make('المغلقة')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', TicketStatusEnum::Closed->value)),
        ];
    }
}

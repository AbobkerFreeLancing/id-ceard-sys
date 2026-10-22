<?php

namespace App\Filament\Student\Resources\Support\Tickets\Pages;

use App\Filament\Student\Resources\Support\Tickets\StudentTicketResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Packages\Enum\PriorityEnum;
use Packages\Enum\TicketStatusEnum;
use Packages\Support\Models\TicketCategory;
use Packages\University\Models\Student;

class CreateStudentTicket extends CreateRecord
{
    protected static string $resource = StudentTicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ticketable_type'] = Student::class;
        $data['ticketable_id'] = student()?->id;
        $data['status'] = TicketStatusEnum::Open;
        $data['priority'] = PriorityEnum::Medium;

        if (empty($data['ticket_category_id'])) {
            $data['ticket_category_id'] = TicketCategory::where('slug', 'student-data-and-photo')->value('id')
                ?? TicketCategory::where('slug', 'support')->value('id')
                ?? TicketCategory::first()?->id;
        }

        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم إرسال تذكرة الدعم الفني بنجاح')
            ->body('سيقوم فريق الدعم الفني بمراجعة طلبك والرد عليك في أقرب وقت.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}

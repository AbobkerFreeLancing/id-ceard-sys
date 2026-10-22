<?php

namespace App\Filament\Student\Resources\Support\Tickets\Pages;

use App\Filament\Student\Resources\Support\Tickets\StudentTicketResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\WithFileUploads;
use Packages\Enum\TicketStatusEnum;
use Packages\Support\Models\TicketReply;
use Packages\University\Models\Student;

class ViewStudentTicket extends ViewRecord
{
    use WithFileUploads;

    protected static string $resource = StudentTicketResource::class;

    protected string $view = 'filament.student.pages.view-ticket';

    public $replyMessage = '';
    public $replyAttachment = null;

    public function getTitle(): string|Htmlable
    {
        return 'متابعة التذكرة: ' . ($this->record->ticket_number ?? ('#' . $this->record->id));
    }

    public function sendReply(): void
    {
        $this->validate([
            'replyMessage' => 'required|string|min:2|max:3000',
            'replyAttachment' => 'nullable|file|max:5120',
        ], [
            'replyMessage.required' => 'يرجى كتابة نص الرد قبل الإرسال.',
            'replyMessage.min' => 'نص الرد قصير جداً.',
        ]);

        $attachmentPath = null;
        if ($this->replyAttachment) {
            $attachmentPath = $this->replyAttachment->store(
                'tickets/' . (student()?->university_no ?? 'general') . '/replies',
                'public'
            );
        }

        TicketReply::create([
            'ticket_id' => $this->record->id,
            'repliable_type' => Student::class,
            'repliable_id' => student()?->id,
            'reply' => $this->replyMessage,
            'attachment' => $attachmentPath,
            'is_internal_note' => false,
        ]);

        // If ticket was closed, re-open it
        if ($this->record->status === TicketStatusEnum::Closed) {
            $this->record->update([
                'status' => TicketStatusEnum::Open,
                'closed_at' => null,
            ]);
        } else {
            $this->record->touch();
        }

        $this->replyMessage = '';
        $this->replyAttachment = null;

        Notification::make()
            ->success()
            ->title('تم إرسال ردك بنجاح')
            ->body('تمت إضافة ردك إلى سجل محادثة التذكرة وسيقوم الدعم الفني بمراجعته.')
            ->send();
    }

    public function closeTicket(): void
    {
        $this->record->update([
            'status' => TicketStatusEnum::Closed,
            'closed_at' => now(),
        ]);

        Notification::make()
            ->success()
            ->title('تم إغلاق التذكرة')
            ->body('تم وسم التذكرة كمغلقة بنجاح. يمكنك إعادة فتحها بإرسال رد جديد في أي وقت.')
            ->send();
    }
}

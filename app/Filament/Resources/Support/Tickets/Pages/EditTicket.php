<?php

namespace App\Filament\Resources\Support\Tickets\Pages;

use App\Filament\Resources\Support\Tickets\TicketResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Packages\Enum\TicketStatusEnum;
use Packages\Support\Models\TicketReply;
use Packages\University\Enums\IdentityTypeEnum;
use Packages\University\Models\StudentIdentity;

class EditTicket extends EditRecord
{
    use WithFileUploads;

    protected static string $resource = TicketResource::class;

    protected string $view = 'filament.resources.support.tickets.pages.edit-ticket';

    // Student fields
    public $student_first_name;
    public $student_second_name;
    public $student_third_name;
    public $student_fourth_name;
    public $student_full_name_en;
    public $student_national_id_number;
    public $student_phone;
    public $student_address;
    public $student_permanent_address;
    public $student_gender;
    public $student_date_of_birth;

    public $student_guardian_name;
    public $student_guardian_phone;
    public $student_guardian_relationship;
    public $student_guardian_job;

    public $new_profile_picture;

    // Document creation
    public $doc_type = 'national_id';
    public $doc_number = '';
    public $doc_file;
    public $doc_notes = '';

    // Active tab in student editor
    public $activeTab = 'photo_docs'; // 'photo_docs', 'personal_info', 'guardian_info'

    // Reply handling
    public $reply_message = '';
    public $reply_attachment;
    public $is_internal_note = false;

    public function getTitle(): string|Htmlable
    {
        return 'إدارة تذكرة الدعم: ' . ($this->record->ticket_number ?? ('#' . $this->record->id));
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $student = $this->record->student;
        if ($student) {
            $this->student_first_name = $student->first_name;
            $this->student_second_name = $student->second_name;
            $this->student_third_name = $student->third_name;
            $this->student_fourth_name = $student->fourth_name;
            $this->student_full_name_en = $student->full_name_en;
            $this->student_national_id_number = $student->national_id_number;
            $this->student_phone = $student->phone ?? $student->guardian_phone;
            $this->student_address = $student->address;
            $this->student_permanent_address = $student->permanent_address;
            $this->student_gender = $student->gender?->value ?? $student->gender;
            $this->student_date_of_birth = $student->date_of_birth ? date('Y-m-d', strtotime($student->date_of_birth)) : null;

            $this->student_guardian_name = $student->guardian_name;
            $this->student_guardian_phone = $student->guardian_phone;
            $this->student_guardian_relationship = $student->guardian_relationship?->value ?? $student->guardian_relationship;
            $this->student_guardian_job = $student->guardian_job;
        }
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function saveStudentInfo(): void
    {
        $student = $this->record->student;
        if (!$student) {
            return;
        }

        $this->validate([
            'student_first_name' => 'required|string|max:50',
            'student_second_name' => 'required|string|max:50',
            'student_third_name' => 'required|string|max:50',
            'student_fourth_name' => 'required|string|max:50',
            'student_national_id_number' => 'nullable|string|max:30',
        ], [
            'student_first_name.required' => 'الاسم الأول مطلوب',
            'student_second_name.required' => 'الاسم الثاني مطلوب',
            'student_third_name.required' => 'الاسم الثالث مطلوب',
            'student_fourth_name.required' => 'الاسم الرابع مطلوب',
        ]);

        $data = [
            'first_name' => $this->student_first_name,
            'second_name' => $this->student_second_name,
            'third_name' => $this->student_third_name,
            'fourth_name' => $this->student_fourth_name,
            'full_name_en' => $this->student_full_name_en,
            'national_id_number' => $this->student_national_id_number,
            'phone' => $this->student_phone,
            'address' => $this->student_address,
            'permanent_address' => $this->student_permanent_address,
            'gender' => $this->student_gender,
            'date_of_birth' => $this->student_date_of_birth,
            'guardian_name' => $this->student_guardian_name,
            'guardian_phone' => $this->student_guardian_phone,
            'guardian_relationship' => $this->student_guardian_relationship,
            'guardian_job' => $this->student_guardian_job,
        ];

        if ($this->new_profile_picture) {
            $path = $this->new_profile_picture->store(
                'students/' . ($student->university_no ?? 'general') . '/profile_pictures',
                'public'
            );
            $data['profile_picture'] = $path;
            $this->new_profile_picture = null;
        }

        $student->update($data);

        Notification::make()
            ->success()
            ->title('تم حفظ وتحديث بيانات الطالب بنجاح!')
            ->body("تم تحديث السجل الأكاديمي والشخصي للطالب {$student->name} بنجاح.")
            ->send();
    }

    public function applyTicketAttachmentAsProfilePicture(): void
    {
        if ($this->record->attachment) {
            $this->applyAttachmentAsProfilePicture($this->record->attachment);
        }
    }

    public function applyTicketAttachmentAsDocument(): void
    {
        if ($this->record->attachment) {
            $this->applyAttachmentAsIdentityProof($this->record->attachment);
        }
    }

    public function applyAttachmentAsProfilePicture(string $attachmentPath): void
    {
        $student = $this->record->student;
        if (!$student || empty($attachmentPath)) {
            return;
        }

        if (!Storage::disk('public')->exists($attachmentPath)) {
            Notification::make()->danger()->title('الملف المرفق غير موجود على الخادم')->send();
            return;
        }

        $ext = pathinfo($attachmentPath, PATHINFO_EXTENSION) ?: 'jpg';
        $uniNo = $student->university_no ?? 'general';
        $targetDir = "students/{$uniNo}/profile_pictures";
        $targetFilename = $targetDir . '/avatar_' . time() . '_' . uniqid() . '.' . $ext;

        Storage::disk('public')->copy($attachmentPath, $targetFilename);

        $student->update([
            'profile_picture' => $targetFilename,
        ]);

        Notification::make()
            ->success()
            ->title('تم اعتماد الصورة كصورة شخصية رسمية للطالب بنجاح!')
            ->body("تم تحديث واعتماد الصورة الشخصية للطالب {$student->name} في ملفه الأكاديمي وبطاقته الجامعية.")
            ->send();
    }

    public function applyAttachmentAsIdentityProof(string $attachmentPath, ?string $number = null, ?string $notes = null): void
    {
        $this->saveAttachmentAsStudentDocument(
            $attachmentPath,
            IdentityTypeEnum::NationalId,
            $number,
            $notes,
            'مستند إثبات شخصية (الرقم الوطني)'
        );
    }

    public function applyAttachmentAsSudaneseCertificate(string $attachmentPath, ?string $number = null, ?string $notes = null): void
    {
        $this->saveAttachmentAsStudentDocument(
            $attachmentPath,
            IdentityTypeEnum::SecondaryCertificate,
            $number,
            $notes,
            'مستند الشهادة السودانية (الثانوية)'
        );
    }

    public function applyAttachmentAsDocument(string $attachmentPath, string $typeValue, ?string $number = null, ?string $notes = null): void
    {
        $type = IdentityTypeEnum::tryFrom($typeValue) ?? IdentityTypeEnum::Other;
        $this->saveAttachmentAsStudentDocument(
            $attachmentPath,
            $type,
            $number,
            $notes,
            $type->getLabel()
        );
    }

    protected function saveAttachmentAsStudentDocument(string $attachmentPath, IdentityTypeEnum $type, ?string $number, ?string $notes, string $label): void
    {
        $student = $this->record->student;
        if (!$student || empty($attachmentPath)) {
            return;
        }

        if (!Storage::disk('public')->exists($attachmentPath)) {
            Notification::make()->danger()->title('الملف المرفق غير موجود على الخادم')->send();
            return;
        }

        $ext = pathinfo($attachmentPath, PATHINFO_EXTENSION) ?: 'jpg';
        $uniNo = $student->university_no ?? 'general';
        $targetDir = "students/{$uniNo}/identities";
        $targetFilename = $targetDir . '/doc_' . $type->value . '_' . time() . '_' . uniqid() . '.' . $ext;

        Storage::disk('public')->copy($attachmentPath, $targetFilename);

        StudentIdentity::create([
            'student_id' => $student->id,
            'type' => $type,
            'number' => $number ?: ($type === IdentityTypeEnum::NationalId ? $student->national_id_number : null),
            'attachment' => $targetFilename,
            'notes' => $notes ?: ('مستند (' . $label . ') معتمد من تذكرة الدعم ' . ($this->record->ticket_number ?? ('#' . $this->record->id))),
        ]);

        Notification::make()
            ->success()
            ->title("تم اعتماد المرفق كـ ({$label}) بنجاح!")
            ->body("تم حفظ المرفق رسمياً ضمن وثائق ومستندات الطالب {$student->name} بالنظام.")
            ->send();
    }

    public function uploadNewStudentDocument(): void
    {
        $student = $this->record->student;
        if (!$student) {
            return;
        }

        $this->validate([
            'doc_type' => 'required',
            'doc_file' => 'required|file|max:10240',
        ], [
            'doc_file.required' => 'يرجى اختيار ملف المستند للرفع',
        ]);

        $path = $this->doc_file->store(
            'students/' . ($student->university_no ?? 'general') . '/identities',
            'public'
        );

        StudentIdentity::create([
            'student_id' => $student->id,
            'type' => $this->doc_type,
            'number' => $this->doc_number,
            'attachment' => $path,
            'notes' => $this->doc_notes,
        ]);

        $this->doc_file = null;
        $this->doc_number = '';
        $this->doc_notes = '';

        Notification::make()
            ->success()
            ->title('تم رفع وإضافة المستند بنجاح!')
            ->send();
    }

    public function deleteStudentDocument(int $id): void
    {
        $doc = StudentIdentity::where('student_id', $this->record->student?->id)->find($id);
        if ($doc) {
            if ($doc->attachment && Storage::disk('public')->exists($doc->attachment)) {
                Storage::disk('public')->delete($doc->attachment);
            }
            $doc->delete();

            Notification::make()->success()->title('تم حذف المستند بنجاح')->send();
        }
    }

    public function setTicketStatus(string $status): void
    {
        $this->record->status = $status;
        if ($status === 'closed') {
            $this->record->closed_at = now();
        } else {
            $this->record->closed_at = null;
        }
        $this->record->save();

        Notification::make()
            ->success()
            ->title('تم تحديث حالة التذكرة إلى: ' . $this->record->status->label())
            ->send();
    }

    public function sendReply(): void
    {
        $this->validate([
            'reply_message' => 'required|string|min:2|max:3000',
            'reply_attachment' => 'nullable|file|max:5120',
        ], [
            'reply_message.required' => 'يرجى كتابة نص الرد قبل الإرسال.',
        ]);

        $attachmentPath = null;
        if ($this->reply_attachment) {
            $attachmentPath = $this->reply_attachment->store('tickets/replies', 'public');
        }

        TicketReply::create([
            'ticket_id' => $this->record->id,
            'repliable_type' => User::class,
            'repliable_id' => auth()->id(),
            'reply' => $this->reply_message,
            'attachment' => $attachmentPath,
            'is_internal_note' => $this->is_internal_note,
        ]);

        $this->reply_message = '';
        $this->reply_attachment = null;
        $this->is_internal_note = false;

        if ($this->record->status === TicketStatusEnum::Open) {
            $this->record->update(['status' => TicketStatusEnum::InProgress]);
        }

        Notification::make()
            ->success()
            ->title('تم إرسال الرد بنجاح')
            ->body('تمت إضافة ردك إلى التذكرة وإتاحتها للطالب فوراً.')
            ->send();
    }
}

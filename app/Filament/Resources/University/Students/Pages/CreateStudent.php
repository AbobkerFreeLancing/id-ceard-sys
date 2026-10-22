<?php

namespace App\Filament\Resources\University\Students\Pages;

use App\Filament\Resources\University\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected array $academicData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. استخراج الحقول الأكاديمية وحفظها في المتغير المؤقت
        $this->academicData = [
            'acceptance_type_id' => $data['acceptance_type_id'] ?? null,
            'academic_status_id' => $data['academic_status_id'] ?? 1,
            'academic_year_id' => $data['academic_year_id'] ?? null,
            'college_id' => $data['college_id'] ?? null,
            'department_id' => $data['department_id'] ?? null,
            'level_id' => $data['level_id'] ?? null,
            'batch_id' => $data['batch_id'] ?? null,
        ];

        // 2. حذف هذه الحقول من $data لكي لا يحاول Filament حفظها في جدول 'students'
        unset(
            $data['acceptance_type_id'],
            $data['academic_status_id'],
            $data['academic_year_id'],
            $data['college_id'],
            $data['department_id'],
            $data['level_id'],
            $data['batch_id'],
        );

        return $data; // سيتم حفظ بيانات الطالب الأساسية فقط في جدول students
    }

    protected function afterCreate(): void
    {
        $student = $this->record;

        // Create academicRecord from the Form Data
        $student->academicRecord()->create($this->academicData);

        // Create medical Checkups Record
        $student->medicalCheckups()->create([
            'ref_number' => 'MD-' . $student->university_no,
            'academic_year_id' => $this->academicData['academic_year_id'],
            'college_id' => $this->academicData['college_id'],
        ]);

        // Create student interview Record
        $student->interviews()->create([
            'ref_number' => 'INT-' . $student->university_no,
            'academic_year_id' => $this->academicData['academic_year_id'],
            'college_id' => $this->academicData['college_id'],
            'status' => \Packages\University\Enums\StudentInterviewStatusEnum::Pending->value,
            'interview_date' => now()->toDateString(),
        ]);
    }
}

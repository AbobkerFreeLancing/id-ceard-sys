<?php

namespace App\Filament\Resources\University\StudentInterviews\Pages;

use App\Filament\Resources\University\StudentInterviews\StudentInterviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentInterview extends CreateRecord
{
    protected static string $resource = StudentInterviewResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['ref_number'])) {
            $data['ref_number'] = 'INT-' . date('Ymd') . '-' . rand(100, 999);
        }

        $data['interview_date'] = now()->toDateString();
        $data['conducted_by'] = auth()->id();
        $data['interviewer_name'] = auth()->user()?->name;
        $data['conducted_at'] = now();

        $isRejected = (!empty($data['status']) && ($data['status'] === 'rejected' || $data['status'] === \Packages\University\Enums\StudentInterviewStatusEnum::Rejected->value));
        if (!$isRejected) {
            $data['rejection_reason'] = null;
        }

        return $data;
    }
}

<?php

namespace App\Filament\Resources\University\StudentInterviews\Pages;

use App\Filament\Resources\University\StudentInterviews\StudentInterviewResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Packages\University\Enums\StudentInterviewStatusEnum;

class EditStudentInterview extends EditRecord
{
    protected static string $resource = StudentInterviewResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['interview_date'] = now()->toDateString();
        $data['conducted_by'] = auth()->id();
        $data['interviewer_name'] = auth()->user()?->name;
        $data['conducted_at'] = now();

        $isRejected = ($data['status'] === StudentInterviewStatusEnum::Rejected->value || $data['status'] === 'rejected');
        if (!$isRejected) {
            $data['rejection_reason'] = null;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()->visible(fn() => auth()->user()?->hasRole('dev')),
        ];
    }
}

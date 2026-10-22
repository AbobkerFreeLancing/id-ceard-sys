<?php
namespace Packages\University\Services;

use Packages\University\Models\AcademicStatus;

trait StudentService
{
    public function RefreshAcademicStatus(AcademicStatus $academicStatus)
    {
        $this->academicRecord->update([
            'status' => $academicStatus->id,
        ]);
    }
}

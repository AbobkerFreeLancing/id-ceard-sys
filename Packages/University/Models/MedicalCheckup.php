<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\University\Enums\MedicalCheckupStatusEnum;

class MedicalCheckup extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => MedicalCheckupStatusEnum::class,
            'has_chronic_diseases' => 'boolean',
            'has_past_surgeries' => 'boolean',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }
}

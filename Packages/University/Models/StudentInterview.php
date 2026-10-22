<?php

namespace Packages\University\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\University\Enums\StudentInterviewStatusEnum;

class StudentInterview extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => StudentInterviewStatusEnum::class,
            'interview_date' => 'date',
            'conducted_at' => 'datetime',
            'score' => 'decimal:2',
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

    public function conductedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'conducted_by');
    }
}

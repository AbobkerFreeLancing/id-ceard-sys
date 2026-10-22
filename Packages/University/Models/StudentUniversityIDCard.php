<?php

namespace Packages\University\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentUniversityIDCard extends Model
{
    protected $guarded = [];

    protected $table = 'student_university_id_cards';

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'issue_date' => 'date',
            'expiry_date' => 'date',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($card) {
            $card->update([
                'ref_number' =>
                    $card?->student->university_no . random_int(10, 99) . date('m') . date('y') . random_int(10, 99),
            ]);
        });
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

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

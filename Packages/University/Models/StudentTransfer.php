<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentTransfer extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function fromBatch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'from_batch_id');
    }

    public function toBatch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'to_batch_id');
    }

    public function fromCollege(): BelongsTo
    {
        return $this->belongsTo(College::class, 'from_college_id');
    }

    public function toCollege(): BelongsTo
    {
        return $this->belongsTo(College::class, 'to_college_id');
    }

    public function fromDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'from_department_id');
    }

    public function toDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'to_department_id');
    }

    public function fromDivision(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'from_division_id');
    }

    public function toDivision(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'to_division_id');
    }

    public function fromLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'from_level_id');
    }

    public function toLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'to_level_id');
    }

    public function fromAcademicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'from_academic_year_id');
    }

    public function toAcademicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'to_academic_year_id');
    }

    public function fromSemester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'from_semester_id');
    }

    public function toSemester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'to_semester_id');
    }

    public function fromFeeStructure(): BelongsTo
    {
        return $this->belongsTo(FeeStructure::class, 'from_fee_structure_id');
    }

    public function toFeeStructure(): BelongsTo
    {
        return $this->belongsTo(FeeStructure::class, 'to_fee_structure_id');
    }

    public function oldInvoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'old_invoice_id');
    }

    public function newInvoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'new_invoice_id');
    }
}

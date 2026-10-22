<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentInstallment extends Model
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

    public function studentCharge(): BelongsTo
    {
        return $this->belongsTo(studentCharge::class);
    }

    public function installmentPlanItem(): BelongsTo
    {
        return $this->belongsTo(InstallmentPlanItem::class);
    }

    public function installmentPlan(): BelongsTo
    {
        return $this->belongsTo(InstallmentPlan::class);
    }
}

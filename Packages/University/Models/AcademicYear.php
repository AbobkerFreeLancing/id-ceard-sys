<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Traits\HasActiveScope;

class AcademicYear extends Model
{
    use HasActiveScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_current' => 'boolean',
            'is_open_for_registration' => 'boolean',
        ];
    }

    public function courseAllocations(): HasMany
    {
        return $this->hasMany(CourseAllocation::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function feeStructures(): HasMany
    {
        return $this->hasMany(FeeStructure::class);
    }

    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class);
    }
}

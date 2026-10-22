<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function courseAllocations(): HasMany
    {
        return $this->hasMany(CourseAllocation::class);
    }

    public function batchCourses(): HasMany
    {
        return $this->hasMany(BatchCourse::class);
    }
}

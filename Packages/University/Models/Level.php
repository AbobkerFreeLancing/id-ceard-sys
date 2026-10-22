<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $guarded = [];

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function courseAllocations(): HasMany
    {
        return $this->hasMany(CourseAllocation::class);
    }
}

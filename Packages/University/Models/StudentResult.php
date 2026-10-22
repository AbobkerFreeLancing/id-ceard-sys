<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentResult extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

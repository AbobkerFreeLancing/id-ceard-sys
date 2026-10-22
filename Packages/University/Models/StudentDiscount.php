<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDiscount extends Model
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

    public function discountPolicy(): BelongsTo
    {
        return $this->belongsTo(DiscountPolicy::class);
    }

    public function studentCharge(): BelongsTo
    {
        return $this->belongsTo(StudentCharge::class);
    }
}

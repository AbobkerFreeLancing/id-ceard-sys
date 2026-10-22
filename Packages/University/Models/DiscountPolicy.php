<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountPolicy extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'eligible_fee_type_ids' => 'array',
            'eligibility_rules' => 'array',
            'starts_on' => 'date',
            'ends_on' => 'date',
        ];
    }
}

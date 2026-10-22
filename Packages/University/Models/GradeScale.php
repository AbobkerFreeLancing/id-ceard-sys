<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;

class GradeScale extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_pass' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}

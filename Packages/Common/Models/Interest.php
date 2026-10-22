<?php

namespace Packages\Common\Models;

use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasEnabledScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
        ];
    }
}

<?php

namespace Packages\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDisabledScope
{
    
    public function scopeDisabled(Builder $query): void
    {
        $query->where('is_enabled', false);
    }
}

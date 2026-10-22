<?php

namespace Packages\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActiveScope
{
    
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}

<?php

namespace Packages\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasVerifiedScope
{
    
    public function scopeVerified(Builder $query): void
    {
        $query->where('is_verified', true);
    }
}

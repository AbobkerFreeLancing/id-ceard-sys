<?php

namespace Packages\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasPublishedScope
{
    
    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_published', true);
    }
}

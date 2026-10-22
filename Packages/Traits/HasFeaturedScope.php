<?php

namespace Packages\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFeaturedScope
{
    
    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }
}

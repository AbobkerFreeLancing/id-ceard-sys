<?php

namespace Packages\Traits;

use Packages\Services\Models\Service;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait BranchHasServicesTrait
{
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}

<?php

namespace Packages\Traits;

use Packages\Common\Models\Branch;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToBranchTrait
{
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}

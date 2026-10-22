<?php

namespace Packages\Common\Models;

use Packages\Traits\HasDisabledScope;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;
    use HasEnabledScope;
    use HasDisabledScope;

    protected $guarded = [];

    const CREATED_AT = null;

    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}

<?php

namespace Packages\Common\Models;

use Packages\Traits\HasDisabledScope;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
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

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}

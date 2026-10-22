<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Traits\HasEnabledScope;

class AbsenceType extends Model
{
    use HasEnabledScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'is_editable' => 'boolean',
        ];
    }

    public function resultDetails(): HasMany
    {
        return $this->hasMany(ResultDetail::class);
    }
}

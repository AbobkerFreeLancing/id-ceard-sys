<?php

namespace Packages\Accounting\Models;

use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    use HasEnabledScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'is_editable' => 'boolean',
        ];
    }

    public function getTypeLabelAttribute()
    {
        return $this->type == 'value' ? __('backend.value') : __('backend.percentage');
    }
}
